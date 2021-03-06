<?php
namespace InteractivePlus\PDK2021Core\APP\APPToken;

use InteractivePlus\LibI18N\MultiLangValueProvider;

class APPTokenScopes{
    private static ?APPTokenScope $SCOPE_BASIC_INFO = null;
    public static function SCOPE_BASIC_INFO() : APPTokenScope{
        if(self::$SCOPE_BASIC_INFO === null){
            self::$SCOPE_BASIC_INFO = new APPTokenScope(
                'info',
                new MultiLangValueProvider('User Info',array('zh'=>'用户信息','en'=>'User Info')),
                new MultiLangValueProvider('Granting this scope allows the APP to read your Mask\'s display name and preferences',array('zh'=>'授予此项权限会让APP有权获取您面具的展示名和偏好设置','en'=>'Granting this scope allows the APP to read your Mask\'s display name and preferences'))
            );
        }
        return self::$SCOPE_BASIC_INFO;
    }
    private static ?APPTokenScope $SCOPE_SEND_NOTIFICATIONS = null;
    public static function SCOPE_SEND_NOTIFICATIONS() : APPTokenScope{
        if(self::$SCOPE_SEND_NOTIFICATIONS === null){
            self::$SCOPE_SEND_NOTIFICATIONS = new APPTokenScope(
                'notifications',
                new MultiLangValueProvider('Send Notifications',array('zh'=>'发送提醒','en'=>'Send Notifications')),
                new MultiLangValueProvider('Granting this scope allows the APP to send you notifications by Email / SMS / Phone Calls through our channel',array('zh'=>'授予此项权限会让APP有权给您通过邮件, 手机短信和电话发送提醒消息','en'=>'Granting this scope allows the APP to send you notifications by Email / SMS / Phone Calls through our channel'))
            );
        }
        return self::$SCOPE_SEND_NOTIFICATIONS;
    }
    private static ?APPTokenScope $SCOPE_SEND_SALES = null;
    public static function SCOPE_SEND_SALES() : APPTokenScope{
        if(self::$SCOPE_SEND_SALES === null){
            self::$SCOPE_SEND_SALES = new APPTokenScope(
                'contact_sales',
                new MultiLangValueProvider('Send Sale Messages',array('zh'=>'发送促销提醒','en'=>'Send Sale Messages')),
                new MultiLangValueProvider('Granting this scope allows the APP to send you sale and event informations by Email / SMS / Phone Calls through our channel',array('zh'=>'授予此项权限会让APP有权给您通过邮件, 手机短信和电话发送销售和活动信息','en'=>'Granting this scope allows the APP to send you sale and event informations by Email / SMS / Phone Calls through our channel'))
            );
        }
        return self::$SCOPE_SEND_SALES;
    }

    private static ?APPTokenScope $SCOPE_STORE_DATA = null;
    public static function SCOPE_STORE_DATA() : APPTokenScope{
        if(self::$SCOPE_STORE_DATA === null){
            self::$SCOPE_STORE_DATA = new APPTokenScope(
                'store_data',
                new MultiLangValueProvider('Store Data On Cloud',array('zh'=>'在云端储存数据','en'=>'Store Data On Cloud')),
                new MultiLangValueProvider('Granting this scope allows the APP to store data on our end on your behalf',array('zh'=>'授予此权限会让APP有权以你的名义在我们的云端储存数据','en'=>'Granting this scope allows the APP to store data on our end on your behalf'))
            );
        }
        return self::$SCOPE_STORE_DATA;
    }
    
    public static function isValidScope(string $scopeValue) : bool{
        switch(strtolower($scopeValue)){
            case self::SCOPE_BASIC_INFO()->getScopeName():
            case self::SCOPE_SEND_NOTIFICATIONS()->getScopeName():
            case self::SCOPE_SEND_SALES()->getScopeName():
            case self::SCOPE_STORE_DATA()->getScopeName():
                return true;
            default:
                return false;
        }
    }
    public static function getScopeObject(string $scopeValue) : ?APPTokenScope{
        switch(strtolower($scopeValue)){
            case self::SCOPE_BASIC_INFO()->getScopeName():
                return self::SCOPE_BASIC_INFO();
            case self::SCOPE_SEND_NOTIFICATIONS()->getScopeName():
                return self::SCOPE_SEND_NOTIFICATIONS();
            case self::SCOPE_SEND_SALES()->getScopeName():
                return self::SCOPE_SEND_SALES();
            case self::SCOPE_STORE_DATA()->getScopeName():
                return self::SCOPE_STORE_DATA();
            default:
                return null;
        }
    }
}