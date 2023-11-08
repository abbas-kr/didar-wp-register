// didar.me
// in register on wordpress, new user will be create in didar site!

function run_curl_after_registration($user_id) {
    $user_info = get_userdata($user_id);
    $name = ($user_info->user_email) ? $user_info->user_email : "کاربر سایت";
    $phone = $user_info->user_login;

    $contact_data = json_encode(array(
        "Contact" => array(
            "FirstName" => $name,
            "MobilePhone" => $phone
        )
    ));

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.didar.me/api/contact/save?ApiKey=<<<YOUR API>>>', // you should replace your api here!
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $contact_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: LocoAuthCookie=3d5312d6-81b6-4087-9ce8-11c7b9b70a44'
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    if(curl_errno($curl)) {
        throw new Exception(curl_error($curl));
    }
    
}

add_action('user_register', 'run_curl_after_registration');
