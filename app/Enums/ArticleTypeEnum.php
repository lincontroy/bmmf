<?php

namespace App\Enums;

enum ArticleTypeEnum: string {

    case HEADER_MENU               = 'header_menu';
    case FOOTER_MENU               = 'footer_menu';
    case HOME_SLIDER               = 'home_slider';
    case SOCIAL_ICON               = 'social_icon';
    case HOME_ABOUT                = 'home_about';
    case ABOUT_US_BANNER           = 'about_us_banner';
    case PACKAGE_BANNER            = 'package_banner';
    case PACKAGE_HEADER            = 'package_header';
    case JOIN_US_TODAY             = 'join_us_today';
    case MERCHANT_TITLE            = 'merchant_title';
    case MERCHANT_CONTENT          = 'merchant_content';
    case MERCHANT_TOP_BANNER       = 'merchant_top_banner';
    case INVESTMENT_HEADER         = 'investment_header';
    case WHY_CHOSE_HEADER          = 'why_choose_header';
    case WHY_CHOSE_CONTENT         = 'why_choose_content';
    case SATISFIED_CUSTOMER_HEADER = 'satisfied_customer_header';
    case CUSTOMER_SATISFY_CONTENT  = 'customer_satisfy_content';
    case FAQ_HEADER                = 'faq_header';
    case FAQ_CONTENT               = 'faq_content';
    case Blog                      = 'blog';
    case Blog_TOP_BANNER           = 'blog_top_banner';
    case Blog_DETAILS_TOP_BANNER   = 'blog_details_top_banner';
    case CONTACT_US_TOP_BANNER     = 'contact_us_top_banner';
    case CONTACT_ADDRESS           = 'contact_address';
    case PAYMENT_WE_ACCEPT_HEADER  = 'payment_we_accept_header';
    case STAKE_BANNER              = 'stake_banner';
    case B2X_LOAN                  = 'b2x_loan';
    case B2X_LOAN_BANNER           = 'b2x_loan_banner';
    case b2x_CALCULATOR_HEADER     = 'b2x_calculator_header';
    case B2X_LOAN_DETAILS_HEADER   = 'b2x_loan_details_header';
    case B2X_LOAN_DETAILS_CONTENT  = 'b2x_loan_details_content';
    case TOP_INVESTOR_BANNER       = 'top_investor_banner';
    case TOP_INVESTOR_TOP_BANNER   = 'top_investor_top_banner';
    case TOP_INVESTOR_HEADER       = 'top_investor_header';
    case OUR_SERVICE_HEADER        = 'our_service_header';
    case OUR_SERVICE               = 'our_service';
    case SERVICE_TOP_BANNER        = 'service_top_banner';
    case OUR_RATES_HEADER          = 'our_rates_header';
    case OUR_RATE_CONTENT          = 'our_rate_content';
    case TEAM_MEMBER_BANNER        = 'team_member_banner';
    case TEAM_HEADER               = 'team_header';
    case OUR_DIFFERENCE_HEADER     = 'our_difference_header';
    case OUR_DIFFERENCE_CONTENT    = 'our_difference_content';
    case BG_EFFECT_IMG             = 'bg_effect_img';
    case QUICK_EXCHANGE            = 'quick_exchange';
}