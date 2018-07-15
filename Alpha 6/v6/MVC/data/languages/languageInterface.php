<?php
interface languageInterface
{
    //THE FLAG OF THE LANGUAGE BEING USED
    function getFlag();

    //ARRAY FOR THE MASTER LOGIN PAGE
    function loginMasterPageTitle();
    function loginMasterPageWriting();
    function loginMasterPagePlayNow();
    function loginMasterPageSignupFree();
    function loginMasterPageAboutTitle();
    function loginMasterPageDescription1($var);
    function loginMasterPageDescription2($var);
    function loginMasterPageDescription3($var);
    function loginMasterPageDescription4($var);
    function loginMasterPageOnPhone($var);

    //ARRAY FOR THE TOP NAV BAR
    function loginNavSignup();
    function loginNavLogin();
    function loginNavPlay();
    function loginNavWiki();
    function loginNavBlog();
    function loginNavLanguage();
    function loginNavNotifications();
    function loginNavCommunity();
    function loginNavSpirit();
    function loginNavScore();
    function loginNavAdmin();
    function loginNavMessages();

    //THE POPUP LOGIN BOX DETAILS
    function loginScreenSignup();
    function loginScreenConnect();
    function loginScrenUsername();
    function loginScreenUsernamePlaceholder();
    function loginScreenPassword();
    function loginScreenPasswordPlaceholder();
    function loginScreenForgottenPassword();
    function loginScreenRememberMe();
    function loginScreenConfirm();

    //THE POPUP FORGOTTEN PASSWORD BOX DETAILS
    function forgottenScreenDetails();
    function forgottenScreenEmailPlaceholder();
    function forgottenScreenEmail();
    function forgottenScreenConfirm();
    function forgottenScreenOr();
    function forgottenScreenContact();
    function forgottenScreenEmailPrep();

    //THE POPUP SIGN UP BOX DETAILS
    function signupScreenLoginLink();
    function signupScreenUsernamePlaceholder();
    function signupScreenUsername();
    function signupScreenUsernameDetails();
    function signupScreenEmailPlaceholder();
    function signupScreenEmail();
    function signupScreenEmailDetails();
    function signupScreenPasswordPlaceholder();
    function signupScreenPassword();
    function signupScreenPasswordDetails();
    function signupScreenPassword2Placeholder();
    function signupScreenPassword2();
    function signupScreenPassword2Details();
    function signupScreenConfirm();

    //THE FOOTER OF THE WEBSITE
    function footerGameName();
    function footerGameVersion();
    function footerHelpfulTitle();
    function footerHelpfulHelp();
    function footerHelpfulWiki();
    function footerHelpfulBug();
    function footerHelpfulNews();
    function footerContactTitle();
    function footerContactCreator();
    function footerContactCredits();
    function footerTwitterLink();

    //THE FORUM THREADS PAGE
    function forumThreadsTitle($var);
    function forumThreadsForums();
    function forumThreadsSearch();
    function forumThreadsRefresh();
    function forumThreadsNewThread();
    function forumThreadsThreads();
    function forumThreadsResponses();
    function forumThreadsPriorityThreads();

    //THE FORUM REPORTING MODAL
    function forumReportingReasons($var);
    function forumReportingInformation();
    function forumReportingInformationDescription();

}