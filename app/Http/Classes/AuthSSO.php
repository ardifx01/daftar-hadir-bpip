<?php

namespace App\Http\Classes;

use App\Exceptions\InvalidAccountException;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MstKegiatan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as ClientGuzzle;

class AuthSSO
{

    private function createProvider()
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => env('OAUTH2_CLIENT_ID'),
            'clientSecret' => env('OAUTH2_CLIENT_SECRET'),
            'redirectUri' => url('/login'),
            'urlAccessToken' => env('OAUTH2_URL_ACCESSTOKEN'),
            'urlAuthorize' => env('OAUTH2_URL_AUTHORIZE'),
            'urlResourceOwnerDetails' => env('OAUTH2_URL_RESOURCE_OWNER')
        ]);
        return $provider;
    }

    private function setAccessToken($value)
    {
        session(['brin_sso_access_token' => $value]);
    }

    private function getAccessToken()
    {
        return session('brin_sso_access_token');
    }

    public function authorize(Request $request)
    {

        $provider = $this->createProvider();

        if (!isset($request->code)) {
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            session(['oauth2state' => $provider->getState()]);
            return [
                'success' => false,
                'redirect_url' => $authUrl,
                'error_message' => '',
            ];
            exit;
            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($request->state) || ($request->state !== $request->session()->get('oauth2state'))) {
            $request->session()->forget('oauth2state');
            exit('Invalid state');
        } else {
            // Try to get an access token (using the authorization code grant)
            try {
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $request->code
                ]);
            } catch (Exception $e) {
                // Failed to get user details
                Log::error($e->getMessage());
                return [
                    'success' => false,
                    'redirect_url' => url('/'),
                    'error_message' => 'Login Failed. Please try again'
                ];
            }
            $this->setAccessToken($accessToken);
            $options['headers']['content-type'] = 'application/json';
            // Optional: Now you have a token you can look up a users profile data
            try {
                $requests = $provider->getAuthenticatedRequest(
                    'GET',
                    env('API_SSO') . 'user/me',
                    $accessToken,
                    $options
                );
                $response = $provider->getParsedResponse($requests);
                if ($response['success'] != true) {
                    throw new InvalidAccountException("Error Processing Request", 1);
                }
                return $response;
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return [
                    'success' => false,
                    'redirect_url' => url('/'),
                    'error_message' => 'Ups...contact your system administrator'
                ];
            }
        }
    }

    private function setSessionToken($value)
    {
        session(['is_login_attendance_form' => $value]);
    }

    public static function getSessionToken()
    {
        return session('is_login_attendance_form');
    }
    public static function token()
    {
        $token = session('is_login_attendance_form');
        return $token;
    }

    public function getFullName(object $userData, object $pegawaiData)
    {
        $fullname = '';
        if (isset($pegawaiData)) {
            $frontAcademicTitle = property_exists($pegawaiData, 'front_academic_title') ? $pegawaiData->front_academic_title . ' ' : '';
            $backAcademicTitle = property_exists($pegawaiData, 'back_academic_title') ?  ', ' . $pegawaiData->back_academic_title : '';
            $name = property_exists($pegawaiData, 'name') ? $pegawaiData->name : $userData->first_name . ' ' . $userData->last_name;
            $fullname = $frontAcademicTitle . $name . $backAcademicTitle;
        } else {
            $fullname = $userData->first_name . ' ' . $userData->last_name;
        }
        return $fullname;
    }

    private function addUser(
        string $username,
        string $email,
        string $usernameIntra,
        string $fullname,
        string $accessToken,
        string $refreshToken,
        int $roleID = 1,
        string $nip,
        string $alamat,
        string $jabatan=null,
        string $golongan,
        string $pangkat,
	string $satuan_kerja,
	string $telepon
    ) {


       $addUser = array(
           'username' => $username,
	   'email' => $email,
	   'usernameIntra' => $usernameIntra,
	   'fullname' => $fullname,
	   'accessToken' => $accessToken,
	   'refreshToken' => $refreshToken,
	   'roleID' => $roleID,
	   'nip' => $nip,
	   'alamat' => $alamat,
	   'jabatan' => $jabatan,
	   'golongan' => $golongan,
	   'pangkat' => $pangkat,
	   'satuan_kerja' => $satuan_kerja
	  // 'telepon' => $telepon
       );
       $telepon = '000';

       //dd($addUser);


        return User::updateOrCreate([
            'email' => $email,
            'username' => $username,
        ], [
            'usernameintra' => $usernameIntra,
            'name' => $fullname,
            'role_id' => $roleID,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'nip' => $nip,
            'alamat' => $alamat,
            'jabatan' => $jabatan,
            'golongan' => $golongan,
            'pangkat' => $pangkat,
            'satuan_kerja' => $satuan_kerja,
            'telepon' => $telepon,
            'instansi' => 'BPIP'
        ]);
    }

    private function addUserCache(
        string $username,
        string $email,
        string $usernameIntra,
        string $fullname,
        string $accessToken,
        string $refreshtoken,
        string $expired,
        int $roleID = 1,
        string $nip,
        string $alamat,
        string $jabatan=null,
        string $golongan,
        string $pangkat,
        string $satuan_kerja,
        int $satuan_kerja_id,
        string $telepon,
        string $instansi

    ) {
        $result = new \stdClass();
        $result->email = $email;
        $result->username = $username;
        $result->name = $fullname;
        $result->usernameintra = $usernameIntra;
        $result->access_token = $accessToken;
        $result->refresh_token = $refreshtoken;
        $result->expired = $expired;
        $result->nip = $nip;
        $result->alamat = $alamat;
        $result->jabatan = $jabatan;
        $result->golongan = $golongan;
        $result->pangkat = $pangkat;
        $result->satuan_kerja = $satuan_kerja;
        $result->satuan_kerja_id = $satuan_kerja_id;
        $result->telepon = $telepon;
        $result->instansi = $instansi;
        Cache::add($accessToken . '#user', $result, 3600);
        Cache::add($accessToken . '#role', $roleID, 3600);
	//dd(Cache::get($accessToken.'#user'));

	return $result;
    }

    private function addRoleIntraCache(string $accessToken, $roleUserIntra)
    {
        Cache::add($accessToken . '#roleUserIntra', $roleUserIntra, 3600);
    }

    private function getCacheData(string $token, string $key)
    {
        return Cache::get($token . '#' . $key);
    }

    public function login(Request $request, string $token = null, string $redirectURL = null, string $slug = null)
    {
        //dd($slug);
       // try {
            $userCache = null;

            if ($token) {
                $userCache = $this->getCacheData($token, 'user');
            }
	//	dd($token);
	//	dd($userCache);
            if ($userCache) {
                Auth::login(User::where('username', $userCache->username)->first());
            } else {
                // dd($userCache);
                $result = $this->authorize($request);
                if ($result['success'] == false) return $result;

                $userData = json_decode(json_encode($result['userData']));
	//	dd($userData);
		$pegawaiData = json_decode(json_encode($result['pegawaiData']));
                if ($userData->active == 0) {
                    return [
                        'success' => false,
                        'redirect_url' => env('APP_URL'),
                        'error_message' => 'Akun Belum Diaktivasi, Silakan cek email anda untuk melakukan aktivasi akun'
                    ];
                }
                $accessToken = $this->getAccessToken();

                $token = $accessToken->getToken();
                $refreshToken = $accessToken->getRefreshToken();
                $expiredToken = $accessToken->getExpires();
                $simpeg =  Http::withToken($token)->get(env('API_HRMS') . 'pegawai/index', [
                    'username_intra' => $userData->username,
                ])->json();
               // dd($simpeg);

                $simpegData =  $simpeg['data'][0];



                // ngasih dummy roleid
                $roleID = 1;

                //akan dijalankan apabila ada inputan env modul_id_app
                if (env('MODUL_ID_APP')) {
                    // untuk ambil role dari intra apabila memiliki role
                    if ($userData->external_account != '1') {
                        $clientIntra = new \GuzzleHttp\Client();
                        $responseIntra = $clientIntra->get(env('API_INTRA') . 'api/user/role?usernameintra=' . $userData->username . '&modul_id=' . env('MODUL_ID_APP'), ['timeout' => 5, 'http_errors' => false]);
                       // dd($responseIntra);
                        $resultintra = json_decode((string) $responseIntra->getBody());
                        if ($resultintra->status == true) {
                            // ngambil id role intra nya karena rolenya di set hanya 1
                            //$roleID = $resultintra->data->role[0]->id;
                            foreach ($resultintra->data->role as $key => $value) {
                                # code...
                                $arr_role[$value->id] = $value->nama;
                            }

                            $this->addRoleIntraCache($accessToken, $arr_role);
                        }
                    }
                }



                 if($userData->email == null){
                    $email = $userData->external_email;
                } if($userData->external_email == null){
                    $email = $userData->username.'@bpip.go.id';
                }else{
                    $email = $userData->username.'@bpip.go.id';
                }

                $fullname = $this->getFullName($userData, $pegawaiData);
	        //dd($simpegData);
		//dd($pegawaiData);
		//dd($simpegData['satker_administrative_text']);
		//
                 $arrUser = array (
                     'username' =>  $userData->username,
                     'email' => $email,
                     'usernameIntra' =>   $pegawaiData->username_intra??$userData->username,
                     'fullname' => $fullname,
                     'accessToken' => $token,
                     'refreshToken' => $refreshToken,
                     'roleID' =>  $roleID,
                     'nip' =>  $pegawaiData->nip??$simpegData['nip'],
                     'alamat' => $simpegData['indo_alamat'],
                     'jabatan' =>  isset($simpegData['jabatan_name'])? $simpegData['jabatan_name']:'-',
                     'golongan' =>  $simpegData['gp_golongan_text']??'-',
                     'pangkat' =>  $simpegData['gp_pangkat_text']??'-',
                     'satuan_kerja' =>  $simpegData['satker_administrative_text'],
                     'telepon' =>  $pegawaiData->resident_telephone_mobile??'-'
                );
               // dd($arrUser);

		$updatedUser = $this->addUser(
                    $userData->username,
                    $email,
                    $pegawaiData->username_intra??$userData->username,
                    $fullname,
                    $token,
                    $refreshToken,
                    $roleID,
                    $pegawaiData->nip??$simpegData['nip'],
                    $simpegData['indo_alamat'],
                    isset($simpegData['jabatan_name'])? $simpegData['jabatan_name']:null,
                    $simpegData['gp_golongan_text']??'-',
                    $simpegData['gp_pangkat_text']??'-',
                    $simpegData['satker_administrative_text'],
                    $pegawaiData->resident_telephone_mobile??'-'
                );
		//	dd($updateUser);
		//	@gelar nambahin isian instansi default biar gak err
		$this->addUserCache(
                    $userData->username,
                    $email,
                    $pegawaiData->username_intra??$userData->username,
                    $fullname,
                    $token,
                    $refreshToken,
                    $expiredToken,
                    $roleID,
                    $pegawaiData->nip??$simpegData['nip'],
                    $simpegData['indo_alamat'],
                    isset($simpegData['jabatan_name'])? $simpegData['jabatan_name']:null,
                    $simpegData['gp_golongan_text']??'-',
                    $simpegData['gp_pangkat_text']??'-',
                    $simpegData['satker_administrative_text'],
                    $simpegData['satker_administrative_id'],
                    '0000000000','BPIP'
                );
                $this->setSessionToken($token);
                Auth::login($updatedUser);
            }
    /*
    } catch (\Exception $e) {
            Log::error($e->getMessage(), ['module' => 'authsso-login']);
            return [
                'success' => false,
                'redirect_url' => url('/'),
                'error_message' => $e->getMessage()
            ];
        }
     */
        // dd(Cache::store('redis')->get($token . "#user"));

        $slug = session()->get('slug');
        // dd($slug);
        if ($slug == null) {
            return [
                'success' => true,
                'redirect_url' => $redirectURL ?? url('/dashboard'),
            ];
        } else {
            return [
                'success' => true,
                'redirect_url' => $redirectURL ?? url('/isi-kehadiran/' . $slug),
            ];
        }
    }

    public static function clearCache(string $token = null)
    {
        if ($token) {
            Cache::forget($token . '#user');
            Cache::forget($token . '#role');
        }
    }

    public static function logout()
    {
        Session::flush();
        Auth::logout();

        $redirectURL = env('SSO_BASE_URL') . 'logout?redirect_uri=' . urldecode(url('/'));
        return [
            'redirect_url' => $redirectURL
        ];
    }
    public static function getSatuanKerja()
    {
        $clientIntra = new ClientGuzzle();
        try {
            $resp = $clientIntra->get(env('API_HRMS') . 'satuan_kerja?active=true&is_satker=true', [
                'headers' => [
                    'Authorization' => 'Bearer ' . AuthSso::token()
                ],
                'form_params' => []
            ]);

            $result = json_decode($resp->getBody());

            if ($result->success == true) {
                return $result;
            } else {
                throw new Exception($result->message);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'success' => false,
                'redirect_url' => url('/'),
                'error_message' => 'Ups...contact your system administrator'
            ];
        }
    }
    public function getUserData(string $token)
    {
        return Http::withToken($token)->get(env('API_SSO') . 'user/me')->json();
    }

    // SIMPEG Data
    // public function getHrmsPegawaiData(string $username, string $token)
    // {

    //     return Http::withToken($token)->get(env('API_HRMS') . 'pegawai/index', [
    //         'username_intra' => $username,
    //     ])->json();
    // }
}
