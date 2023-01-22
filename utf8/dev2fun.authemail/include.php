<?php
/**
 * @author dev2fun (darkfriend)
 * @copyright (c) 2020, darkfriend
 * @version 1.0.6
 */

if (class_exists('dev2funModelAuthEmailClass')) return;

class dev2funModelAuthEmailClass
{
    const LOGIN_KEY = 'USER_LOGIN';
    const PASSWORD_KEY = 'USER_PASSWORD';

    public static function auth()
    {
        global $APPLICATION;
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        if (strpos($APPLICATION->GetCurDir(), '/bitrix/admin/') !== false) {
            return;
        }

        $keys = \Bitrix\Main\Config\Option::get('dev2fun.authemail', 'keys');
        if ($keys) {
            $keys = unserialize($keys, ["allowed_classes" => false]);
        }
        if(empty($keys) || !is_array($keys)) {
            $keys = [];
        } else {
            foreach ($keys as $k => &$key) {
                $arrKeys = explode(':', $key);
                if (empty($arrKeys[0])) {
                    unset($keys[$k]);
                    continue;
                }
                $key = [
                    'EMAIL' => $arrKeys[0],
                    'PASSWORD' => $arrKeys[1] ?? 'USER_PASSWORD',
                ];
            }
            unset($key);
        }
        array_unshift(
            $keys,
            [
                'EMAIL' => self::LOGIN_KEY,
                'PASSWORD' => self::PASSWORD_KEY,
            ]
        );

        $requestKey = [];
        $filter = [];
        foreach ($keys as $key) {
            if (!empty($_POST[$key['EMAIL']])) {
                $requestKey = $key;
                if (filter_var($_POST[$key['EMAIL']], FILTER_VALIDATE_EMAIL)) {
                    $filter['=EMAIL'] = $_POST[$key['EMAIL']];
                } else {
                    $filter['=LOGIN'] = $_POST[$key['EMAIL']];
                }
                break;
            }
        }

        if(!$requestKey) {
            return;
        }

        $rsUser = \CUser::GetList(
            "ID",
            "ASC",
            $filter,
            [
                'SELECT' => ['EMAIL', 'LOGIN'],
            ]
        );
        while ($arU = $rsUser->GetNext()) {
            if ($arU['EMAIL'] === $_POST[$requestKey['EMAIL']]) {
                $_POST[self::LOGIN_KEY] = $arU['LOGIN'];
                $_POST[self::PASSWORD_KEY] = $_POST[$requestKey['PASSWORD']];
            }
        }
    }
}