<?php
/**
 * @author dev2fun (darkfriend)
 * @copyright darkfriend
 * @version 1.0.6
 */
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

if (!$USER->isAdmin()) {
    $APPLICATION->authForm('Nope');
}
$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();
$curModuleName = 'dev2fun.authemail';
//Loc::loadMessages($context->getServer()->getDocumentRoot()."/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);

$aTabs = [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('MAIN_TAB_SET'),
        'ICON' => 'main_settings',
        'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_SET'),
    ],
];

$tabControl = new CAdminTabControl('tabControl', $aTabs);

if ($request->isPost() && check_bitrix_sessid()) {

    $arFields = [];
    $keys = $request->getPost('keys');
    if ($keys) {
        foreach ($keys as $k => $v) {
            if (!$v) {
                unset($keys[$k]);
            }
        }
        if ($keys) {
            $keys = serialize($keys);
        } else {
            $keys = '';
        }
        $arFields['keys'] = $keys;
    }

    foreach ($arFields as $k => $arField) {
        Option::set($curModuleName, $k, $arField);
    }
}
$tabControl->begin();
?>
<script type="text/javascript">
    <?=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$curModuleName.'/js/script.js')?>
</script>

<form
    method="post"
    action="<?= sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID) ?>&<?= $tabControl->ActiveTabParam() ?>"
    enctype="multipart/form-data"
    name="editform"
    class="editform"
>
    <?php
    echo bitrix_sessid_post();
    $tabControl->beginNextTab();
    ?>
    <!--    <tr class="heading">-->
    <!--        <td colspan="2"><b>--><?php //echo GetMessage("D2F_COMPRESS_HEADER_SETTINGS")?><!--</b></td>-->
    <!--    </tr>-->

    <tr>
        <td width="40%">
            <label>
                <?= Loc::getMessage('D2F_AUTH_EMAIL_KEYS') ?>:
            </label>
        </td>
        <td width="60%">
            <table class="nopadding" cellpadding="0" cellspacing="0" border="0" width="100%" id="d2f_mapping_list">
                <tbody>
                <?php
                $keys = Option::get($curModuleName, 'keys');
                $lastKey = 0;
                if ($keys) {
                    $keys = unserialize($keys, ["allowed_classes" => false]);
                    foreach ($keys as $k => $v) {
                        ?>
                        <tr>
                            <td>
                                <input
                                    type="text"
                                    size="50"
                                    name="keys[n<?=$lastKey?>]"
                                    value="<?=$v?>"
                                    placeholder="USER_LOGIN:USER_PASSWORD"
                                />
                            </td>
                        </tr>
                        <?php
                        $lastKey++;
                    } ?>
                <?php } ?>
                <tr>
                    <td>
                        <input type="text"
                               size="50"
                               name="keys[n<?=$lastKey?>]"
                               value=""
                               placeholder="USER_LOGIN:USER_PASSWORD"
                        />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input
                            type="button"
                            value="<?=Loc::getMessage("D2F_AUTH_EMAIL_LABEL_ADD");?>"
                            onclick="addNewRow('d2f_mapping_list')"
                        />
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <?php
    $tabControl->Buttons([
        "btnSave" => true,
        "btnApply" => true,
        "btnCancel" => true,
        "back_url" => $APPLICATION->GetCurUri(),
    ]);
    $tabControl->End();
    ?>
</form>