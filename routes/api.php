<?php

/* Users */
// getters
$router->get('/user', ['uses' => 'User\UserBrowseController@get', 'middleware' => ['LogActivity:User.View','ArrQuery']]);
$router->get('/user/{query:.+}', ['uses' => 'User\UserBrowseController@get', 'middleware' => ['LogActivity:User.View','ArrQuery']]);
// actions
$router->post('/user', ['uses' => 'User\UserController@Insert', 'middleware' => ['LogActivity:User.Insert','User.Insert']]);
$router->put('/user/change_password', ['uses' => 'User\UserController@ChangePassword', 'middleware' => ['LogActivity:User.ChangePassword','User.ChangePassword']]);
$router->put('/user/{id}', ['uses' => 'User\UserController@Update', 'middleware' => ['LogActivity:User.Update','User.Update']]);
$router->post('/user/reset_password', ['uses' => 'User\UserController@ResetPassword', 'middleware' => ['LogActivity:User.ResetPassword','User.ResetPassword']]);
$router->post('/user/change_status', ['uses' => 'User\UserController@ChangeStatus', 'middleware' => ['LogActivity:User.ChangeStatus','User.ChangeStatus']]);

$router->post('/user/sync', ['uses' => 'User\UserController@Sync', 'middleware' => ['LogActivity:User.Sync1']]);
$router->post('/user/sync1', ['uses' => 'User\UserController@Sync1', 'middleware' => ['LogActivity:User.Sync1']]);
$router->post('/user/sync2', ['uses' => 'User\UserController@Sync2', 'middleware' => ['LogActivity:User.Sync2']]);
$router->post('/user/sync3', ['uses' => 'User\UserController@Sync3', 'middleware' => ['LogActivity:User.Sync3']]);
$router->post('/user/sync4', ['uses' => 'User\UserController@Sync4', 'middleware' => ['LogActivity:User.Sync4']]);
$router->post('/user/sync5', ['uses' => 'User\UserController@Sync5', 'middleware' => ['LogActivity:User.Sync5']]);


$router->get('/clear_mail_transaction', ['uses' => 'Mail\MailController@clearMailTransaction', 'middleware' => ['LogActivity:Mail.clearMailtransaction']]);

$router->delete('/user/{id}', ['uses' => 'User\UserController@Delete', 'middleware' => ['LogActivity:Mail.Delete','User.Delete']]);
// Developer
$router->post('/user/{id}/developer/token', ['uses' => 'User\UserController@DeveloperToken', 'middleware' => ['User.Developer.Token']]);

/* Blast Position */
// getters
$router->get('/position', ['uses' => 'Position\PositionBrowseController@get', 'middleware' => ['LogActivity:Position.View','ArrQuery']]);
$router->get('/position/{query:.+}', ['uses' => 'Position\PositionBrowseController@get', 'middleware' => ['LogActivity:Position.View','ArrQuery']]);
// actions
$router->post('/position', ['uses' => 'Position\PositionController@Insert', 'middleware' => ['LogActivity:Position.Insert','Position.Insert']]);
$router->put('/position/{id}', ['uses' => 'Position\PositionController@Update', 'middleware' => ['LogActivity:Position.Update','Position.Update']]);
$router->delete('/position/{id}', ['uses' => 'Position\PositionController@Delete', 'middleware' => ['LogActivity:Position.Delete','Position.Delete']]);
$router->post('/position/change_status', ['uses' => 'Position\PositionController@ChangeStatus', 'middleware' => ['LogActivity:Position.ChangeStatus','Position.ChangeStatus']]);

// mail
$router->get('/mail', ['uses' => 'Mail\MailBrowseController@get', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);
$router->get('/mail/{query:.+}', ['uses' => 'Mail\MailBrowseController@get', 'middleware' => ['LogActivity:Mail.View','ArrQuery']]);
$router->post('/mail', ['uses' => 'Mail\MailController@Insert', 'middleware' => ['LogActivity:Mail.Insert','Mail.Insert']]);
$router->post('/mail/upload_surat_masuk', ['uses' => 'Mail\MailController@InsertUploadSuratMasuk', 'middleware' => ['LogActivity:Mail.InsertUploadSuratMasuk','Mail.InsertUploadSuratMasuk']]);
$router->post('/mail/approve', ['uses' => 'Mail\MailController@Approve', 'middleware' => ['LogActivity:Mail.Approve', 'Mail.Approve']]);
$router->post('/mail/mail_number', ['uses' => 'Mail\MailController@SaveMailNumber', 'middleware' => ['LogActivity:Mail.SaveMailNumber', 'Mail.SaveMailNumber']]);
$router->post('/mail/request_mail_number', ['uses' => 'Mail\MailController@RequestMailNumber', 'middleware' => ['LogActivity:Mail.RequestMailNumber', 'Mail.RequestMailNumber']]);
$router->post('/mail/cancel_request_mail_number', ['uses' => 'Mail\MailController@CancelRequestMailNumber', 'middleware' => ['LogActivity:Mail.CancelRequestMailNumber', 'Mail.CancelRequestMailNumber']]);

$router->post('/mail/maker_send', ['uses' => 'Mail\MailController@MakerSend', 'middleware' => ['LogActivity:Mail.MakerSend','Mail.MakerSend']]);
$router->post('/mail/reject', ['uses' => 'Mail\MailController@Reject', 'middleware' => ['LogActivity:Mail.Reject','Mail.Reject']]);
$router->post('/mail/dispose', ['uses' => 'Mail\MailController@Dispose', 'middleware' => ['LogActivity:Mail.Dispose','Mail.Dispose']]);
$router->put('/mail/{id}', ['uses' => 'Mail\MailController@Update', 'middleware' => ['LogActivity:Mail.Update','Mail.Update']]);
$router->delete('/mail/{id}', ['uses' => 'Mail\MailController@Delete', 'middleware' => ['LogActivity:Mail.Delete','Mail.Delete']]);

$router->post('/mail_disposition_reply', ['uses' => 'MailDispositionReply\MailDispositionReplyController@Insert', 'middleware' => ['LogActivity:MailDispositionReply.Insert','MailDispositionReply.Insert']]);

// mail template
$router->get('/mail_template', ['uses' => 'MailTemplate\MailTemplateBrowseController@get', 'middleware' => ['LogActivity:Template.View', 'ArrQuery']]);
$router->get('/mail_template/{query:.+}', ['uses' => 'MailTemplate\MailTemplateBrowseController@get', 'middleware' => ['LogActivity:Template.View','ArrQuery']]);

$router->post('/upload', ['uses' => 'File\FileController@Upload', 'middleware' => ['LogActivity:File.Upload','File.Upload']]);

$router->post('/storage/save', ['uses' => 'Storage\StorageController@Save', 'middleware' => ['LogActivity:File.Save','Storage.Save']]);

// mail
$router->get('/log_activity', ['uses' => 'LogActivity\LogActivityBrowseController@get', 'middleware' => ['LogActivity:LogActivity.View', 'ArrQuery']]);
$router->get('/log_activity/{query:.+}', ['uses' => 'LogActivity\LogActivityBrowseController@get', 'middleware' => ['LogActivity:LogActivity.View','ArrQuery']]);


// information
$router->get('/information', ['uses' => 'Information\InformationBrowseController@get', 'middleware' => ['LogActivity:Information.View', 'ArrQuery']]);
$router->get('/information/{query:.+}', ['uses' => 'Information\InformationBrowseController@get', 'middleware' => ['LogActivity:Information.View','ArrQuery']]);
$router->post('/information', ['uses' => 'Information\InformationController@Insert', 'middleware' => ['LogActivity:Information.Insert','Information.Insert']]);
$router->put('/information/{id}', ['uses' => 'Information\InformationController@Update', 'middleware' => ['LogActivity:Information.Update','Information.Update']]);
$router->delete('/information/{id}', ['uses' => 'Information\InformationController@Delete', 'middleware' => ['LogActivity:Information.Delete','Information.Delete']]);

// mail number classification
$router->get('/mail_number_classification', ['uses' => 'MailNumberClassification\MailNumberClassificationBrowseController@get', 'middleware' => ['LogActivity:MailNumberClassification.View','ArrQuery']]);
$router->get('/mail_number_classification/{query:.+}', ['uses' => 'MailNumberClassification\MailNumberClassificationBrowseController@get', 'middleware' => ['MailNumberClassification:MailNumberClassification.View','ArrQuery']]);
$router->post('/mail_number_classification', ['uses' => 'MailNumberClassification\MailNumberClassificationController@Insert', 'middleware' => ['LogActivity:MailNumberClassification.Insert','MailNumberClassification.Insert']]);
$router->put('/mail_number_classification/{id}', ['uses' => 'MailNumberClassification\MailNumberClassificationController@Update', 'middleware' => ['LogActivity:MailNumberClassification.Update','MailNumberClassification.Update']]);
$router->delete('/mail_number_classification/{id}', ['uses' => 'MailNumberClassification\MailNumberClassificationController@Delete', 'middleware' => ['LogActivity:MailNumberClassification.Delete','MailNumberClassification.Delete']]);

// mail number classification
$router->get('/config_numbering', ['uses' => 'ConfigNumbering\ConfigNumberingBrowseController@get', 'middleware' => ['LogActivity:ConfigNumbering.View','ArrQuery']]);
$router->get('/config_numbering/{query:.+}', ['uses' => 'ConfigNumbering\ConfigNumberingBrowseController@get', 'middleware' => ['LogActivity:ConfigNumbering.View','ArrQuery']]);
$router->put('/config_numbering/{id}', ['uses' => 'ConfigNumbering\ConfigNumberingController@Update', 'middleware' => ['LogActivity:ConfigNumbering.Update','ConfigNumbering.Update']]);

// config
$router->get('/config', ['uses' => 'Config\ConfigBrowseController@get', 'middleware' => ['LogActivity:Config.View','ArrQuery']]);
$router->get('/config/{query:.+}', ['uses' => 'Config\ConfigBrowseController@get', 'middleware' => ['Config:Config.View','ArrQuery']]);
$router->post('/config', ['uses' => 'Config\ConfigController@Insert', 'middleware' => ['LogActivity:Config.Insert','Config.Insert']]);
$router->put('/config/{id}', ['uses' => 'Config\ConfigController@Update', 'middleware' => ['LogActivity:Config.Update','Config.Update']]);
$router->delete('/config/{id}', ['uses' => 'Config\ConfigController@Delete', 'middleware' => ['LogActivity:Config.Delete','Config.Delete']]);


$router->get('/notification/{query:.+}', ['uses' => 'Notification\NotificationBrowseController@get', 'middleware' => ['LogActivity:Notification.View','ArrQuery']]);
