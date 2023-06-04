<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Front Methods

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
   $route['default_controller'] = 'Frontcontroller';
   $route['privacy-policy'] = 'Frontcontroller/privacyPolicy';
 /*$route['privacy-policy'] = "Ccontroller/privacyPolicy";*/
/* $route['game-result-chart/(:any)'] = "Ccontroller/viewchart"; 
$route['submit-user-query'] = 'Ccontroller/submitUserQuery';
$route['privacy-policy'] = 'Ccontroller/privacyPolicy'; */
/*$route['game-result-chart/(:any)'] = 'Acontroller/gameResultChart'; */

$route['game-result-chart/(:any)'] = 'Acontroller/gameResultChart';


// Admin
$route[admin] = "admin/Logincontroller/login";
$route[admin.'/change-password'] = "admin/Logincontroller/changePassword";
$route[admin.'/logout'] = "admin/Logincontroller/logout";
$route[admin.'/dashboard'] = "admin/Dashboardcontroller/welcomeAdmin";
$route['un-approved-user-list-grid-data'] = "admin/Dashboardcontroller/unApprovedUserListGridData";
$route['get-market-bid-details'] = "admin/Dashboardcontroller/getMarketBidDetails";
$route['get-search-market-bid-details'] = "admin/Dashboardcontroller/getSearchBidDetails";

/////auto depos


$route['auto-fund-request-list-grid-data'] = "admin/Dashboardcontroller/autoFundRequestListGridData";

$route['accept-auto-fund-request'] = "admin/Dashboardcontroller/acceptAutoFundRequest";
$route['reject-auto-fund-request'] = "admin/Dashboardcontroller/rejectAutoFundRequest";
$route['delete-auto-request-depo'] = "admin/Dashboardcontroller/deleteAutoRequestDepo";



//admin method using ajax
$route['loginCheck'] = "admin/Logincontroller/loginCheck";//for login
$route['forgot-password'] = "admin/Logincontroller/forgotPassword";//for forget password
$route['update-password'] = "admin/Logincontroller/updatePassword";//for update password
$route['delete-data'] = "admin/Econtroller/deleteData";
$route['block-data-function'] = "admin/Blockdatacontroller/blockDataFunction";//for block data
$route['market-open-close-function'] = "admin/Blockdatacontroller/marketOpenCloseFunction";//for Market Open Close
$route['get-captcha'] = "admin/Logincontroller/getCaptcha";
$route['refresh-captcha'] = "admin/Logincontroller/refreshCaptcha";


//User Management
$route[admin.'/user-management'] = "admin/Usercontroller/userManagement";
$route['user-list-grid-data'] = "admin/Usercontroller/userListGridData";
$route[admin.'/view-user/(:any)'] = "admin/Usercontroller/viewUser";
$route['accept-fund-request'] = "admin/Usercontroller/acceptFundRequest";
$route['reject-fund-request'] = "admin/Usercontroller/rejectFundRequest";
$route['all-transaction-table-grid-data'] = "admin/Usercontroller/allTransactionTableGridData";
$route['credit-transaction-table-grid-data'] = "admin/Usercontroller/creditTransactionTableGridData";
$route['debit-transaction-table-grid-data'] = "admin/Usercontroller/debitTransactionTableGridData";
$route['user-bid-history-table-grid-data'] = "admin/Usercontroller/userBidHistoryTableGridData";
$route['user-winning-history-data'] = "admin/Usercontroller/userWinningHistoryData";
$route['allowed-betting'] = "admin/Usercontroller/allowedBetting";

$route['change-logout-status'] = "admin/Usercontroller/changeLogoutStatus";

// Sub Admin Management
$route[admin.'/sub-admin-management'] = "admin/Admincontroller/subAdminManagement";
$route['sub-admin-list-grid-data'] = "admin/Admincontroller/subAdminListGridData";
$route['add-sub-admin'] = "admin/Admincontroller/addSubAdmin";

// Add Fund User Wallet Management
$route[admin.'/add-fund-user-wallet-management'] = "admin/Usercontroller/addFundUserWalletManagement";
$route['add-balance-user-wallet'] = "admin/Usercontroller/addBalanceUserWallet";
$route['withdraw-balance-user-wallet'] = "admin/Usercontroller/withdrawBalanceUserWallet";


$route['change-security-pin'] = "admin/Usercontroller/changeSecurityPin";


// Fund Request Management
$route[admin.'/fund-request-management'] = "admin/FundRequestcontroller/fundRequestManagement";
$route['fund-request-list-grid-data'] = "admin/FundRequestcontroller/fundRequestListGridData";

// Withdraw Request Management
$route[admin.'/withdraw-request-management'] = "admin/WithdrawRequestcontroller/withdrawRequestManagement";
$route['withdraw-request-list-grid-data'] = "admin/WithdrawRequestcontroller/withdrawRequestListGridData";
$route[admin.'/view-withdraw-request/(:any)'] = "admin/WithdrawRequestcontroller/viewWithdrawRequest";
$route['approve-withdraw-request'] = "admin/WithdrawRequestcontroller/approveWithdrawRequest";
$route['reject-withdraw-request'] = "admin/WithdrawRequestcontroller/rejectWithdrawRequest";

// Notice Management
$route[admin.'/notice-management'] = "admin/Noticecontroller/noticeManagement";
$route['notice-list-grid-data'] = "admin/Noticecontroller/noticeListGridData";
$route['add-notice'] = "admin/Noticecontroller/addNotice";
$route[admin.'/edit-notice/(:any)'] = "admin/Noticecontroller/editNotice";

// Admin Settings
$route[admin.'/main-settings'] = "admin/Adminsettingcontroller/mainSettings";
$route['add-admin-bank-detail'] = "admin/Adminsettingcontroller/addAdminBankDetail";
$route['add-admin-upi-detail'] = "admin/Adminsettingcontroller/addAdminUpiDetail";
$route['add-admin-upi-update-otp-check'] = "admin/Adminsettingcontroller/addAdminUpiUpdateOtpCheck";
$route['add-app-link'] = "admin/Adminsettingcontroller/addAppLink";
$route['add-admin-fix-values'] = "admin/Adminsettingcontroller/addAdminFixValues";

//Game Rates
$route[admin.'/game-rates'] = "admin/Gameratescontroller/gameRatesManagement";
$route['add-game-rates'] = "admin/Gameratescontroller/addGameRates";

//Game Name
$route[admin.'/game-name'] = "admin/Gamenamecontroller/gameNameManagement";
$route['game-name-list-grid-data'] = "admin/Gamenamecontroller/gameNameListGridData";
$route['add-game'] = "admin/Gamenamecontroller/addgame";
$route[admin.'/edit-game/(:any)'] = "admin/Gamenamecontroller/editgame";
$route[admin.'/off-day/(:any)'] = "admin/Gamenamecontroller/offdaygame";
$route['add-off-day'] = "admin/Gamenamecontroller/addoffday";
$route[admin.'/winning-prediction'] = "admin/Resultcontroller/winningPrediction";	
$route['get-predict-winner-list'] = "admin/Resultcontroller/getpredictWinnerList";
$route['check-open-market-result-declaration'] = "admin/Resultcontroller/checkOpenMarketResulDeclaration";

////////////////// Star Line

//Game Name
$route[admin.'/starline-game-name'] = "admin/Starlinegamecontroller/starlineGameNameManagement";
$route['starline-game-name-list-grid-data'] = "admin/Starlinegamecontroller/starlineGameNameListGridData";
$route['add-starline-game'] = "admin/Starlinegamecontroller/addStarlineGame";
$route[admin.'/edit-starline-game/(:any)'] = "admin/Starlinegamecontroller/editgame";

//Game Rates
$route[admin.'/starline-game-rates'] = "admin/Starlinegamecontroller/starlineGameRatesManagement";
$route['add-starline-game-rates'] = "admin/Starlinegamecontroller/addStarelineGameRates";


// User Bid History
$route[admin.'/starline-user-bid-history'] = "admin/Starlinebidhistorycontroller/userBidHistory";
$route['get-starline-bid-history-data'] = "admin/Starlinebidhistorycontroller/getStarlineBidHistoryData";
$route['export-option-starline-bid-history-data'] = "admin/Starlinebidhistorycontroller/exportOptionBidHistoryData";


 // decleare-result
$route[admin.'/starline-decleare-result'] = "admin/Starlineresultcontroller/decleareResult";
/*$route[admin.'/starline-winning-report'] = "admin/Starlineresultcontroller/winningReport"; */


$route['get-decleare-starline-game-data'] = "admin/Starlineresultcontroller/getDecleareGameData";
$route['save-open-starline-game-data'] = "admin/Starlineresultcontroller/saveOpenData";
$route['decleare-open-starline-data'] = "admin/Starlineresultcontroller/decleareOpenData";


$route['delete-open-starline-result-data'] = "admin/Starlineresultcontroller/deleteOpenResultData";
$route['get-open-starline-winner-list'] = "admin/Starlineresultcontroller/getOpenWinnerList";


//starlineselreport
 
$route[admin.'/starline-sell-report'] = "admin/Starlinesellcontroller/starlineSellReport";
$route['get-starline-sell-report'] = "admin/Starlinesellcontroller/getStarlineSellReport";


//starlinewinningreport
 
 $route[admin.'/starline-winning-report'] = "admin/Starlinewinningcontroller/starlineWinningReport";
$route['get-starline-winning-report'] = "admin/Starlinewinningcontroller/getStarlineWinningReport"; 


//StarLine Result History
$route[admin.'/starline-result-history'] = "admin/Starlinewinningcontroller/starlineResultHistory";
$route['starline-result-history-list-grid-data'] = "admin/Starlinewinningcontroller/starlineResultHistoryListGridData";

$route['starline-result-history-list-load-data'] = "admin/Starlinewinningcontroller/starlineResultHistoryListLoadData";
//StarLine Winning Prediction
$route[admin.'/starline-winning-prediction'] = "admin/Starlinewinningcontroller/starlineWinningPrediction";
$route['get-starline-winner-list'] = "admin/Starlinewinningcontroller/getStarlineWinnerList";

//////////////starline ednd




////////////////// Gali Disswar Start

//Game Name
$route[admin.'/galidisswar-game-name'] = "admin/Galidisswargamecontroller/GalidisswarGameNameManagement";
$route['galidisswar-game-name-list-grid-data'] = "admin/Galidisswargamecontroller/galidisswarGameNameListGridData";
$route['add-galidisswar-game'] = "admin/Galidisswargamecontroller/addGalidisswarGame";
$route[admin.'/edit-galidisswar-game/(:any)'] = "admin/Galidisswargamecontroller/editgame";

//Game Rates
$route[admin.'/galidisswar-game-rates'] = "admin/Galidisswargamecontroller/galidisswarGameRatesManagement";
$route['add-galidisswar-game-rates'] = "admin/Galidisswargamecontroller/addgalidisswarGameRates";


// User Bid History
$route[admin.'/galidisswar-user-bid-history'] = "admin/Galidisswarbidhistorycontroller/userBidHistory";
$route['get-galidisswar-bid-history-data'] = "admin/Galidisswarbidhistorycontroller/getgalidisswarBidHistoryData";
$route['export-option-galidisswar-bid-history-data'] = "admin/Galidisswarbidhistorycontroller/exportOptionBidHistoryData";


$route[admin.'/edit-bid-galidissawar-history/(:any)'] = "admin/Galidisswarbidhistorycontroller/editgalidisswarBidHistory";

$route['update-galidissawar-bid'] = "admin/Galidisswarbidhistorycontroller/updateGaliDissawarBid";




// decleare-result
$route[admin.'/galidisswar-decleare-result'] = "admin/Galidisswarresultcontroller/decleareResult";
$route[admin.'/galidisswar-winning-report'] = "admin/Galidisswarresultcontroller/winningReport";


$route['get-decleare-galidisswar-game-data'] = "admin/Galidisswarresultcontroller/getDecleareGameData";
$route['get-open-data'] = "admin/Resultcontroller/getOpenData";
$route['get-close-data'] = "admin/Resultcontroller/getCloseData";
$route['save-open-galidisswar-game-data'] = "admin/Galidisswarresultcontroller/saveOpenData";
$route['decleare-open-galidisswar-data'] = "admin/Galidisswarresultcontroller/decleareOpenData";

$route['get-open-galidisswar-winner-list'] = "admin/Galidisswarresultcontroller/getOpenWinnerList";


$route['delete-open-galidisswar-result-data'] = "admin/Galidisswarresultcontroller/deleteOpenResultData";


//galidisswarselreport
 
$route[admin.'/galidisswar-sell-report'] = "admin/Galidisswarsellcontroller/galidisswarSellReport";
$route['get-galidisswar-sell-report'] = "admin/Galidisswarsellcontroller/getgalidisswarSellReport";


//galidisswarwinningreport
 
$route[admin.'/galidisswar-winning-report'] = "admin/Galidisswarwinningcontroller/galidisswarWinningReport";
$route['get-galidisswar-winning-report'] = "admin/Galidisswarwinningcontroller/getgalidisswarWinningReport";


//galidisswar Result History
$route[admin.'/galidisswar-result-history'] = "admin/Galidisswarwinningcontroller/galidisswarResultHistory";
$route['galidisswar-result-history-list-grid-data'] = "admin/Galidisswarwinningcontroller/galidisswarResultHistoryListGridData";


$route['galidisswar-result-history-list-load-data'] = "admin/Galidisswarwinningcontroller/galidisswarResultHistoryListLoadData";


//Galidissawar Winning Prediction
$route[admin.'/galidisswar-winning-prediction'] = "admin/Galidisswarwinningcontroller/galidisswarWinningPrediction";
$route['get-galidissawar-winner-list'] = "admin/Galidisswarwinningcontroller/getGalidissarWinnerList";

//////////////Gali Disswar end



//Bid Revert
$route[admin.'/bid-revert'] = "admin/Bidrevertcontroller/bidRevert";
$route['get-bid-revert-data'] = "admin/Bidrevertcontroller/getBidRevertData";
$route['refund-amount'] = "admin/Bidrevertcontroller/refundAmount";



//game & nuumbers
$route[admin.'/single-digit'] = "admin/Gamenumbercontroller/singleDigit";
$route[admin.'/jodi-digit'] = "admin/Gamenumbercontroller/jodiDigit";
$route[admin.'/single-pana'] = "admin/Gamenumbercontroller/singlepana";
$route[admin.'/double-pana'] = "admin/Gamenumbercontroller/doublepana";
$route[admin.'/tripple-pana'] = "admin/Gamenumbercontroller/tripplepana";
$route[admin.'/half-sangam'] = "admin/Gamenumbercontroller/halfsangam";
$route[admin.'/full-sangam'] = "admin/Gamenumbercontroller/fullsangam";

// Games Time Management
$route[admin.'/games-time-management'] = "admin/Gameratescontroller/gamesTimeManagement";
$route['add-games-time'] = "admin/Gameratescontroller/addGamesTime";
$route['change-game-time'] = "admin/Gameratescontroller/changeGameTime";

// How To Play
$route[admin.'/how-to-play'] = "admin/Gameratescontroller/howToPlay";
$route['tinymce-upload-image'] = "admin/Gameratescontroller/tinymceUploadImage";
$route['add-how-to-play-data'] = "admin/Gameratescontroller/addHowToPlayData";


// Slider Images
$route[admin.'/slider-images-management'] = "admin/Sliderimagecontroller/sliderImagesManagement";
$route['slider-images-list-grid-data'] = "admin/Sliderimagecontroller/sliderImagesListGridData";
$route['add-slider-image'] = "admin/Sliderimagecontroller/addSliderImage";
$route['delete-image'] = "admin/Sliderimagecontroller/deleteImage";

// User Bid History
$route[admin.'/user-bid-history'] = "admin/Bidhistorycontroller/userBidHistory";
$route[admin.'/edit-bid-history/(:any)'] = "admin/Bidhistorycontroller/editBidHistory";
$route['get-bid-history-data'] = "admin/Bidhistorycontroller/getBidHistoryData";
$route['export-option-bid-history-data'] = "admin/Bidhistorycontroller/exportOptionBidHistoryData";


$route[admin.'/un-approved-users-list'] = "admin/Dashboardcontroller/unApprovedUsersList";



// declare-result
$route[admin.'/declare-result'] = "admin/Resultcontroller/declareResult";
$route[admin.'/winning-report'] = "admin/Resultcontroller/winningReport";
$route[admin.'/main-market'] = "admin/Mainmarketcontroller/mainMarket";
$route[admin.'/edit-bid/(:any)'] = "admin/Mainmarketcontroller/editBid";
$route['update-bid'] = "admin/Mainmarketcontroller/updateBid";
$route['main-market-report'] = "admin/Mainmarketcontroller/mainMarketreport";
$route['show-digit'] = "admin/Mainmarketcontroller/showDigit";

$route['get-winning-history-data'] = "admin/Resultcontroller/getWinningHistoryData";

$route[admin.'/result-history'] = "admin/Resultcontroller/resultHistory";
$route['result-history-list-grid-data'] = "admin/Resultcontroller/resultHistoryListGridData";
$route['result-history-list-load-data'] = "admin/Resultcontroller/resultHistoryListLoadData";

$route['get-decleare-game-data'] = "admin/Resultcontroller/getDecleareGameData";
$route['save-open-data'] = "admin/Resultcontroller/saveOpenData";
$route['decleare-open-data'] = "admin/Resultcontroller/decleareOpenData";
$route['decleare-close-data'] = "admin/Resultcontroller/decleareCloseData";
$route['save-close-data'] = "admin/Resultcontroller/saveCloseData";


$route['open-result-notification-continusly'] = "admin/Resultcontroller/openResultNotificationContinusly";



$route['delete-open-result-data'] = "admin/Resultcontroller/deleteOpenResultData";
$route['get-open-winner-list'] = "admin/Resultcontroller/getOpenWinnerList";
$route['get-close-winner-list'] = "admin/Resultcontroller/getCloseWinnerList";


$route['delete-close-result-data'] = "admin/Resultcontroller/deleteCloseResultData";





// Contact Settings
$route[admin.'/contact-settings'] = "admin/contactsettingcontroller/contactSettings";
$route['add-contact-settings'] = "admin/contactsettingcontroller/addContactSettings";

// User Query
$route[admin.'/users-querys'] = "admin/userquerycontroller/usersQuerys";
$route['users-querys-list-grid-data'] = "admin/userquerycontroller/usersQueryListGridData";

// Tips Management
$route[admin.'/tips-management'] = "admin/Dashboardcontroller/tipsManagement";
$route['tips-list-grid-data'] = "admin/Dashboardcontroller/tipsListGridData";
$route['add-tips'] = "admin/Dashboardcontroller/addTips";
$route[admin.'/edit-tips/(:any)'] = "admin/Dashboardcontroller/editTips";
$route[admin.'/view-tips/(:any)'] = "admin/Dashboardcontroller/viewTips";

////send notification

$route[admin.'/send-notification'] = "admin/Noticecontroller/sendNotification";
$route['user-send-notification'] = "admin/Noticecontroller/userSendNotification";

//customer Sell Report
$route[admin.'/customer-sell-report'] = "admin/Customersellcontroller/customerSellReport";
$route['get-customer-sell-report'] = "admin/Customersellcontroller/getCustomerSellReport";



//Wallet Report
$route[admin.'/wallet-report'] = "admin/Walletcontroller/walletReport";
$route['get-wallet-report'] = "admin/Walletcontroller/getWalletReport";



//Chat Question Management
$route[admin.'/chat-ques-management']="admin/Chatquescontroller/chatQuesManagement";
$route[admin.'/add-ques/(:any)'] = "admin/Chatquescontroller/addQues";
$route[admin.'/submit-ques'] = "admin/Chatquescontroller/submitQues";
$route['ques-list-grid-data'] = "admin/Chatquescontroller/quesListGridData";
$route[admin.'/view-ques/(:any)'] = "admin/Chatquescontroller/viewQues";



//Chat Support Maangement
$route[admin.'/chat-support-management']="admin/Chatsupportcontroller/chatSupportManagement";
$route['get-user-data']="admin/Chatsupportcontroller/getUserData";
$route['get-user-search']="admin/Chatsupportcontroller/getUserSearch";
$route[admin.'/submit-admin-msg']="admin/Chatsupportcontroller/submitAdminMsg";





//Roulette game management
$route[admin.'/roulette-game-name']="admin/Roulettegamecontroller/rouletteGameName";
$route[admin.'/add-roulette-game/(:any)']="admin/Roulettegamecontroller/addRouletteGame";
$route['submit-roulette-game']="admin/Roulettegamecontroller/submitRouletteGame";
$route['roulette-game-name-list-grid-data']="admin/Roulettegamecontroller/rouletteGameNameListGridData";


//Roulette Bid History

$route[admin.'/roulette-bid-history'] = "admin/Roulettegamebidcontroller/rouletteBidHistory";
$route['get-roulette-bid-history-data'] = "admin/Roulettegamebidcontroller/getRouletteBidHistoryData";
$route['export-option-roulette-bid-history-data'] = "admin/Roulettegamebidcontroller/exportOptionBidHistoryData";


//Roulette Result History
$route[admin.'/roulette-result-history'] = "admin/Rouletteresultcontroller/rouletteResultHistory";
$route['roulette-result-history-list-grid-data'] = "admin/Rouletteresultcontroller/rouletteResultHistoryListGridData";


/*--------------------------*/
$route['get-game-list-for-result'] = "admin/Resultcontroller/getGameListForResult";


//Roulette Winning Report
$route[admin.'/roulette-winning-report'] = "admin/Rouettewinningcontroller/rouletteWinningReport";
$route['get-roulette-winning-report'] = "admin/Rouettewinningcontroller/getRouletteWinningReport";

$route['add-app-maintainence'] = "admin/Adminsettingcontroller/addAppMaintainence";

// Auto Deposite History
$route[admin.'/auto-deposite-history'] = "admin/Autodepositecontroller/autoDepositeHistory";
$route['get-auto-deposite-history'] = "admin/Autodepositecontroller/getAutoDepositeHistory";


/////////////////////**** API ****/////////////////////

/////////////////////**** API ****/////////////////////
$route['api-get-app-key'] = "Apicontroller/apiGetAppKey";

$route['api-check-mobile'] = "Apicontroller/apiCheckMobile";
$route['api-otp-sent'] = "Apicontroller/apiOtpSent";
$route['api-resend-otp'] = "Apicontroller/apiResendOtp";
$route['api-user-registration'] = "Apicontroller/apiUserRegistration";
$route['api-user-login'] = "Apicontroller/apiUserLogin";
$route['api-change-password'] = "Apicontroller/apiChangePassword";
$route['api-update-pin'] = "Apicontroller/apiUpdatePin";
$route['api-forgot-password'] = "Apicontroller/apiForgotPassword";
$route['api-forget-check-mobile'] = "Apicontroller/apiForgetCheckmobile";
$route['api-get-state'] = "Apicontroller/apiGetState";
$route['api-get-district'] = "Apicontroller/apiGetDistrict";
$route['api-add-user-address'] = "Apicontroller/apiAddUserAddress";
$route['api-get-user-address'] = "Apicontroller/apiGetUserAddress";
$route['api-get-profile'] = "Apicontroller/apiGetProfile";
$route['api-profile-update'] = "Apicontroller/apiProfileUpdate";

$route['api-check-security-pin'] = "Apicontroller/apiCheckSecurityPin";




$route['api-admin-bank-details'] = "Apicontroller/apiAdminBankDetails";
$route['api-fund-request-add'] = "Apicontroller/apiFundRequestAdd";
$route['api-last-fund-request-detail'] = "Apicontroller/apiLastFundRequestDetail";
$route['api-fund-payment-slip-upload'] = "Apicontroller/apiFundPaymentSlipUpload";
$route['api-add-user-bank-details'] = "Apicontroller/apiAddUserBankDetails";
$route['api-add-user-upi-details'] = "Apicontroller/apiAddUserUpiDetails";
$route['api-get-user-payment-details'] = "Apicontroller/apiGetUserPaymentDetails";
$route['api-game-rates'] = "Apicontroller/apiGameRates";
$route['api-fund-request-history'] = "Apicontroller/apiFundRequestHistory";
$route['api-user-wallet-balance'] = "Apicontroller/apiUserWalletBalance";
$route['api-check-user-for-transfer-amt'] = "Apicontroller/apiCheckUserForTransferAmt"; 
$route['api-user-transfer-wallet-balance'] = "Apicontroller/apiUserTransferWalletBalance";
$route['api-user-payment-method-list'] = "Apicontroller/apiUserPaymentMethodList";
$route['api-user-withdraw-fund-request'] = "Apicontroller/apiUserWithdrawFundRequest";
$route['api-get-notice'] = "Apicontroller/apiGetNotices";
$route['api-how-to-play'] = "Apicontroller/apiHowToPlay";
$route['api-wallet-transaction-history'] = "Apicontroller/apiWalletTransactionHistory";
$route['api-view-wallet-transaction-history'] = "Apicontroller/apiViewWalletTransactionHistory";
$route['api-user-withdraw-transaction-history'] = "Apicontroller/apiUserWithdrawTransactionHistory";


$route['api-get-dashboard-data'] = "Apicontroller/apiGetDashboardData";
$route['api-get-slider-images'] = "Apicontroller/apiGetSliderImages";
$route['api-get-current-date'] = "Apicontroller/apiGetCurrentDate";
$route['api-check-games-active-inactive'] = "Apicontroller/apiCheckGamesActiveInactive";
$route['api-submit-bid'] = "Apicontroller/apiSubmitBid";
$route['api-bid-history-data'] = "Apicontroller/apiBidHistoryData";
$route['api-get-contact-details'] = "Apicontroller/apiGetContactDetails";
$route['api-submit-contact-us'] = "Apicontroller/apiSubmitContactUs";
$route['api-get-notification'] = "Apicontroller/apiGetNotification";

$route['api-wining-result'] = "Apicontroller/apiWiningResult";
$route['api-wining-history-data'] = "Apicontroller/apiWiningHistoryData";

$route['api-get-tips-list'] = "Apicontroller/apiGetTipsList";
$route['api-view-tips-details'] = "Apicontroller/apiViewTipsDetails";


$route['api-check-game-status'] = "Apicontroller/apiCheckGameStatus";
$route['api-notification-setting'] = "Apicontroller/apiNotificationSetting";
$route['api-get-statement'] = "Apicontroller/apiGetStatement";
$route['api-add-money-via-upi'] = "Apicontroller/apiAddMoneyViaUpi";
$route['checkNotifiation'] = "Apicontroller/checkNotifiation";

$route['api-get-app-version-details'] = "Apicontroller/apiGetAppVersionDetails";


//////////////starline///////////////

$route['api-starline-game-rates'] = "Apicontroller/apiStarlineGameRates";
$route['api-starline-game'] = "Apicontroller/apiStarlineGame";
$route['api-check-starline-game-status'] = "Apicontroller/apiCheckStarLineGameStatus";
$route['api-check-starline-games-active-inactive'] = "Apicontroller/apiCheckStarLineGamesActiveInactive";
$route['api-starline-submit-bid'] = "Apicontroller/apiStarlineSubmitBid";
$route['api-starline-bid-history-data'] = "Apicontroller/apiStarlineBidHistoryData";
$route['api-starline-wining-history-data'] = "Apicontroller/apiStarlineWiningHistoryData";



//////////////Gali Disswar///////////////

$route['api-galidisswar-game-rates'] = "Apicontroller/apiGaliDisswarGameRates";
$route['api-galidisswar-game'] = "Apicontroller/apiGaliDisswarGame";
$route['api-check-galidisswar-game-status'] = "Apicontroller/apiCheckGaliDisswarGameStatus";
$route['api-check-galidisswar-games-active-inactive'] = "Apicontroller/apiCheckGaliDisswarGamesActiveInactive";
$route['api-galidisswar-submit-bid'] = "Apicontroller/apiGaliDisswarSubmitBid";
$route['api-galidisswar-bid-history-data'] = "Apicontroller/apiGaliDisswarBidHistoryData";
$route['api-galidisswar-wining-history-data'] = "Apicontroller/apiGaliDisswarWiningHistoryData";




//////////////Roulette///////////////

$route['api-roulette-game'] = "Apicontroller/apiRouletteGame";
$route['api-get-roulette-game-time'] = "Apicontroller/apiGetRouletteGameTime";
$route['api-check-roulette-game-status'] = "Apicontroller/apiCheckRouletteGameStatus";
$route['api-get-roulette-game-info'] = "Apicontroller/apiGetRouletteGameInfo";
$route['api-roulette-submit-bid'] = "Apicontroller/apiRouletteSubmitBid";
$route['api-get-roulette-game-winning-number'] = "Apicontroller/apiGetRouletteGameWinningNumber";
$route['api-roulette-bid-history-data'] = "Apicontroller/apiRouletteBidHistoryData";
$route['api-roulette-wining-history-data'] = "Apicontroller/apiRouletteWiningHistoryData";



$route['api-get-sp-motor-combination'] ="Apicontroller/apiGetSpDPMotorCombination";
$route['api-get-sp-dp-tp-combination'] ="Apicontroller/apiGetSpDpTpCombination";

//////////declare result
$route['roulette-result-declare'] = "Apicontroller/rouletteResultDeclare";


////API Chat App
$route['api-chat-app'] ="Apicontroller/apiChatApp";
$route['api-get-chat-app'] ="Apicontroller/apiGetChatApp";


$route['api-get-user-network'] = "Apicontroller/apiGetUserNetwork";
$route['api-check-refer-valid'] = "Apicontroller/apiCheckReferValid";
$route['checkMoneyToReferral'] = "Apicontroller/checkMoneyToReferral";




//Transfer Point Report
$route[admin.'/transfer-point-report'] = "admin/Transfercontroller/transferPointReport";
$route['get-transfer-report'] = "admin/Transfercontroller/getTransferReport";



// Report
$route[admin.'/bid-winning-report'] = "admin/Reportcontroller/bidWinningReport";
$route['get-bid-winning-report-details'] = "admin/Reportcontroller/getBidWinningReportDetails";
$route['get-bid-report-list'] = "admin/Reportcontroller/getBidReportList";
$route['get-winning-report-details'] = "admin/Reportcontroller/getWinningReportDetails";

$route[admin.'/withdraw-report'] = "admin/Reportcontroller/withdrawReport";
$route['get-withdraw-report-details'] = "admin/Reportcontroller/getWithdrawReportDetails";

// Clear Data
$route[admin.'/clear-data'] = "admin/Cleardatacontroller/clearData";
$route['clear-data-date-wise'] = "admin/Cleardatacontroller/clearDataDateWise";
$route['clear-data-date-wise/(:any)'] = "admin/Cleardatacontroller/clearDataDateWise";
$route['clean-database-data'] = "admin/Cleardatacontroller/cleanDatabaseData";
$route['wallet-transaction-backup'] = "admin/Cleardatacontroller/walletTransactionBackup";
$route['wallet-transaction-backup/(:any)'] = "admin/Cleardatacontroller/walletTransactionBackup";

$route[admin.'/starline-off-day/(:any)'] = "admin/Starlinegamecontroller/starlineOffdayGame";
$route[admin.'/galidisawar-off-day/(:any)'] = "admin/Galidisswargamecontroller/galidisawarOffdayGame";

$route['api-get-auto-deposit-list'] ="Apicontroller/apiGetAutoDepositList";

$route['api-validate-bank'] ="Apicontroller/apiValidateBank";
$route['api-get-social-data'] ="Apicontroller/apiGetSocialData";


$route['game-result-chart-details'] = "Acontroller/gameResultDetailsChart";
$route['game-result-galidessar-chart-details'] = "Acontroller/galidisswarResultDetailsChart";


$route['delete_row'] = "Deletecontroller/deleteRow";
$route['delete_row_data'] = "Deletecontroller/deletRowData";



// Auto Referral history
$route[admin.'/get-referral-amount-data'] = "admin/Referralcontroller/getReferralAmountData";
$route['get-referral-amount-history'] = "admin/Referralcontroller/getReferralAmountHistory";


// Referral bonus 
$route[admin.'/referral-bonus-settings'] = "admin/Adminsettingcontroller/referralBonusSettings";
$route['add-referral-bonus-settings-update'] = "admin/Adminsettingcontroller/referralBonusSettingsUpdate";


////////////////ADMIN APP API LIST ////////////////
$route['api-get-admin-dashboard-data'] = "Adminapicontroller/apiGetDashboardData";
$route['api-get-bid-single-ank'] = "Adminapicontroller/apiGetBidSingleAnk";
$route['api-get-market-bid-amount']  = "Adminapicontroller/apiGetMarketBidAmount";
$route['api-auto-fund-request-list-data']  = "Adminapicontroller/apiAutoFundRequestListData";
$route['api-get-contact-setting-data']  = "Adminapicontroller/apiGetContactSettingData";
$route['api-update-contact-setting-data']  = "Adminapicontroller/apiGetUpdateSettingData";
$route['api-get-admin-setting-data']  = "Adminapicontroller/apiGetAdminSettingData";
$route['api-add-app-maintainence']  = "Adminapicontroller/apiAddAppMaintainence";
$route['api-update-admin-bank-detail']  = "Adminapicontroller/apiUpdateAdminBankDetail";
$route['api-update-admin-bank-detail']  = "Adminapicontroller/apiUpdateAdminBankDetail";
$route['api-add-admin-upi-detail-send-otp']  = "Adminapicontroller/apiAddAdminUpiDetailSendOtp";
$route['api-admin-upi-update-otp-verified']  = "Adminapicontroller/apiAdminUpiUpdateOtpVerified";
$route['api-add-app-link']  = "Adminapicontroller/apiAddAppLink";
$route['api-add-admin-fix-values']  = "Adminapicontroller/apiAddAdminFixValues";


$route['api-add-admin-fix-values']  = "Adminapicontroller/apiAddAdminFixValues";
$route['api-get-rates-list']  = "Adminapicontroller/apiGetRatesList";
$route['api-update-rates-list']  = "Adminapicontroller/apiUpdateRatesList";
$route['api-game-name-list']  = "Adminapicontroller/apiGameNameList";
$route['api-active-inactive-game']  = "Adminapicontroller/apiActiveInactiveGame";
$route['api-game-name-add']  = "Adminapicontroller/apiGameNameAdd";
$route['api-game-name-update']  = "Adminapicontroller/apiGameNameUpdate";
$route['api-get-game-market-off-day-data']  = "Adminapicontroller/apiGetGameMarketOffDayData";

$route['api-update-game-time']  = "Adminapicontroller/apiUpdateGameTime";


$route['api-get-game-list-dropdown']  = "Adminapicontroller/apiGetGameListDropdown";
$route['api-get-main-game-user-bid-history']  = "Adminapicontroller/apiGetMainGameUserBidHistory";
$route['api-get-user-list']  = "Adminapicontroller/apiGetUserList";
$route['api-get-unapproved-user-list']  = "Adminapicontroller/apiGetUnapprovedUserList";
$route['api-change-user-betting-status']  = "Adminapicontroller/apiChangeUserBettingStatus";
$route['api-change-user-transfer-status']  = "Adminapicontroller/apiChangeUserTransferStatus";
$route['api-change-user-active-status']  = "Adminapicontroller/apiChangeUserActiveStatus";
$route['api-get-customer-sell-report']  = "Adminapicontroller/apiGetCustomerSellReport";
$route['api-get-view-user-profile']  = "Adminapicontroller/apiGetViewUserProfile";

$route['api-change-logout-status'] = "Adminapicontroller/apiChangeLogoutStatus";
$route['api-change-security-pin'] = "Adminapicontroller/apiChangeSecurityPin";
$route['api-add-fund-to-user'] = "Adminapicontroller/apiAddFundToUser";
$route['api-witdraw-fund-from-user'] = "Adminapicontroller/apiWitdrawFundFromUser";

$route['api-accept-auto-fund-request'] = "Adminapicontroller/apiAcceptAutoFundRequest";
$route['api-reject-auto-fund-request'] = "Adminapicontroller/apiRejectAutoFundRequest";
$route['api-delete-auto-request-deposit'] = "Adminapicontroller/apidDeleteAutoRequestDepo";


$route['api-user-auto-fund-request-list-data']  = "Adminapicontroller/apiUserAutoFundRequestListData";
$route['api-user-withdraw-request-list-data']  = "Adminapicontroller/apiUserWithdrawRequestListData";
$route['api-user-view-withdraw-request']  = "Adminapicontroller/apiUserViewWithdrawRequest";

$route['api-get-main-game-particular-user-bid-history']  = "Adminapicontroller/apiGetMainGameParticularUserBidHistory";
$route['api-get-user-wallet-history']  = "Adminapicontroller/apiGetUserWalletHistory";
$route['api-get-user-winning-history']  = "Adminapicontroller/apiGetUserWinningHistory";
$route['api-get-search-user-list']  = "Adminapicontroller/apiGetSearchUserList";


//declare result
$route['api-save-open-result-data']  = "Adminapicontroller/apiSaveOpenResultData";
$route['api-get-open-winner-list']  = "Adminapicontroller/apiGetOpenWinnerList";
$route['api-declare-open-result-data']  = "Adminapicontroller/apiDeclareOpenResultData";


//declare Close result
$route['api-save-close-result-data']  = "Adminapicontroller/apiSaveCloseResultData";
$route['api-get-close-winner-list']  = "Adminapicontroller/apiGetCloseWinnerList";
$route['api-declare-close-result-data']  = "Adminapicontroller/apiDeclareCloseResultData";
$route['api-delete-open-result-data']  = "Adminapicontroller/apiDeleteOpenResultData";
$route['api-delete-close-result-data']  = "Adminapicontroller/apiDeleteCloseResultData";

$route['api-result-history-list-load-data']  = "Adminapicontroller/apiResultHistoryListLoadData";
$route['api-get-winning-prediction']  = "Adminapicontroller/apiGetWinningPrediction";
$route['api-get-winning-report']  = "Adminapicontroller/apiGetWinningReport";
$route['api-get-transfer-point-report']  = "Adminapicontroller/apiGetTransferPointReport";
$route['api-get-bid-winning-report-details']  = "Adminapicontroller/apiGetBidWinningReportDetails";
$route['api-get-bid-win-report-list']  = "Adminapicontroller/apiGetBidWinReportDetails";
$route['api-get-bid-winner-list']  = "Adminapicontroller/apiGetBidWinnerList";
$route['api-get-withdrawal-list']  = "Adminapicontroller/apiGetWithdrawalList";
$route['api-approve-withdraw-request']  = "Adminapicontroller/apiApproveWithdrawRequest";
$route['api-reject-withdraw-request']  = "Adminapicontroller/apiRejectWithdrawRequest";
$route['api-auto-deposit-history']  = "Adminapicontroller/apiAutoDepositHistory";
$route['api-get-referral-amount-history']  = "Adminapicontroller/apiGetReferralAmountHistory";



////////////Starline///////////////
$route['api-get-starline-rates-list']  = "Adminapicontroller/apiGetStarlineRatesList";
$route['api-starline-update-rates-list']  = "Adminapicontroller/apiStarlineUpdateRatesList";
$route['api-starline-game-name-list']  = "Adminapicontroller/apiStarlineGameNameList";
$route['api-starline-active-inactive-game']  = "Adminapicontroller/apiStarlineActiveInactiveGame";
$route['api-starline-market-status-game']  = "Adminapicontroller/apiStarlineMarketStatusGame";
$route['api-starline-game-name-update']  = "Adminapicontroller/apiStarlineGameNameUpdate";
$route['api-starline-game-name-add']  = "Adminapicontroller/apiStarlineGameNameAdd";

$route['api-get-starline-game-list-dropdown']  = "Adminapicontroller/apiGetStarlineGameListDropdown";

$route['api-get-starline-user-bid-history']  = "Adminapicontroller/apiGetStarlineUserBidHistory";
$route['api-save-starline-result-data']  = "Adminapicontroller/apiSaveStarlineResultData";
$route['api-starline-declare-result']  = "Adminapicontroller/apiStarlineDeclareResult";
$route['api-starline-sell-report']  = "Adminapicontroller/apiStarlineSellReport";
$route['api-get-starline-winning-prediction']  = "Adminapicontroller/apiGetStarlineWinningPrediction";

$route['api-starline-delete-result'] = "Adminapicontroller/apiDeleteStarlineResultData";




////////////Gali Dessawar Game///////////////
$route['api-get-gali-dessawar-rates-list']  = "Adminapicontroller/apiGetGaliDessawarRatesList";
$route['api-gali-dessawar-update-rates-list']  = "Adminapicontroller/apiGaliDessawarUpdateRatesList";
$route['api-gali-dessawar-game-name-list']  = "Adminapicontroller/apiGaliDessawarGameNameList";
$route['api-gali-dessawar-active-inactive-game']  = "Adminapicontroller/apiGaliDessawaActiveInactiveGame";
$route['api-gali-dessawar-market-status-game']  = "Adminapicontroller/apiGaliDessawarMarketStatusGame";
$route['api-gali-dessawar-name-update']  = "Adminapicontroller/apiGaliDessawarNameUpdate";
$route['api-gali-dessawar-game-name-add']  = "Adminapicontroller/apiGaliDessawarGameNameAdd";

$route['api-get-gali-dessawar-game-list-dropdown']  = "Adminapicontroller/apiGetGaliDessawarGameListDropdown";

$route['api-get-gali-dessawar-user-bid-history']  = "Adminapicontroller/apiGetGaliDessawarUserBidHistory";
$route['api-save-gali-dessawar-result-data']  = "Adminapicontroller/apiSaveGaliDessawarResultData";
$route['api-gali-dessawar-declare-result']  = "Adminapicontroller/apiGaliDessawarDeclareResult";
$route['api-gali-dessawar-sell-report']  = "Adminapicontroller/apiGaliDessawarSellReport";
$route['api-get-gali-dessawar-winning-prediction']  = "Adminapicontroller/apiGetGaliDessawarWinningPrediction";


$route['api-gali-dessawar-result-history-list'] = "Adminapicontroller/apiGaliDessawarResultHistoryList";
$route['api-gali-dessawar-winning-report'] = "Adminapicontroller/apiGaliDessawarWinningReport";
$route['api-gali-dessawar-delete-result'] = "Adminapicontroller/apiDeleteGaliDessawarResultData";

$route['api-update-gali-dessawar-bid']  = "Adminapicontroller/apiUpdateGaliDessawarBid";



$route['api-active-inactive-notice']  = "Adminapicontroller/apiActiveInactiveNotice";
$route['api-notice-add']  = "Adminapicontroller/apiNoticeAdd";
$route['api-notice-update']  = "Adminapicontroller/apiNoticeUpdate";
$route['api-notice-list']  = "Adminapicontroller/apiNoticeList";
$route['api-update-bid']  = "Adminapicontroller/apiUpdateBid";

$route['api-starline-result-history-list'] = "Adminapicontroller/apiStarlineResultHistoryList";
$route['api-starline-winning-report'] = "Adminapicontroller/apiStarlineWinningReport";

$route['api-chat'] = "Adminapicontroller/apiChat";
$route['api-get-chat'] = "Adminapicontroller/apiGetChat";
$route['api-insert-chat-data'] = "Adminapicontroller/apiInsertChatData";
$route['11getadminpass11'] = "admin/Logincontroller/getadminpass";
$route['encrypted-data'] = "admin/Logincontroller/encryptedData";

$route['viewtable'] = 'Acontroller/viewtable';
$route['exportCSV'] = 'Acontroller/exportCSV';


