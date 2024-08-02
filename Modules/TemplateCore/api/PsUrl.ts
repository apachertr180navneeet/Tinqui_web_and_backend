export default class PsUrl {
    static ps_follower_item_url =
        "/follow/item_from_follower?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_detail_url =
        "/product/get_product?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_location_township_url =
        "/location-township/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_deal_option_url =
        "/options/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    // static ps_sub_cat_url =
    //     "/subcategories/get?language_symbol=" +
    //     (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_sub_cat_url =
        "/sub_category/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_sub_cat_search_url =
        "/sub_category/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_is_user_subscribed =
        "/subcat_subscribe/is_user_subscribed?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_category_url =
        "/category/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_category_with_subcategories_url =
        "/category/getwithSubCategories?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_packages_url =
        "/package_in_app_purchase?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_packages_with_purchased_count_url =
        "/package_in_app_purchase/package_purchased_count?language_symbol=" +
        localStorage.activeLanguage;

    static ps_package_bought_url =
        "/package_bought?language_symbol=" + localStorage.activeLanguage;

    static ps_limit_ad_item_list_url =
        "/package_bought/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_search_item_url: String =
        "/product/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_all_search_url: String =
        "/product/all_search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_search_history_url: String =
        "/search_history/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_delete_search_history_url: String =
        "/search_history/destroy?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_phone_country_url: String =
        "/phone_country_code/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_related_item_url: String =
        "/product/get_related?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_customfield_url: String =
        "/product/create?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_customfield_url: String =
        "/user/create?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_customize_deail_url: String = "/product/customize-header";

    static ps_search_user_url: String =
        "/follow/search_follow_user?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_top_rated_seller_url: String =
        "/user/top_rated_seller?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_follow_url: String =
        "/follow/follow_user?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_blocked_user_url: String =
        "/block/get_blocked_user_by_loginuser?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_reported_item_url: String =
        "/complaint_item?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_detail_url: String =
        "/userfollows/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_search_user_keyword_url: String =
        "/user/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_chat_history_url: String =
        "/chat/get_buyer_seller_list?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_add_chat_history_url: String =
        "/chat?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_accepted_offer_url: String =
        "/chat/update_accept?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_rejected_offer_url: String =
        "/chats/update_price?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_is_user_bought_url: String =
        "/chat/is_user_bought?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_maked_offer_url: String =
        "/chat/update_price?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_get_chat_history_url: String =
        "/chat/get_chat_history?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_mark_as_sold_url: String =
        "/chat/item_sold_out?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_sold_out_item_url: String =
        "/items/get_sold_item_list?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_about_us_url: String =
        "/about?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_mark_sold_out_url: String =
        "/product/sold_out_item_detail?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_product_status_change_url: String =
        "/product/item_status_change?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_report_item_url: String =
        "rest/itemreports/add?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_block_user_url: String =
        "/block/block_user?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_blue_mark_user_url: String =
        "/user/verify_blue_mark?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_unblock_user_url: String =
        "/block/unblock_user?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_reset_unread_message_count_url: String =
        "/chat/reset_count?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_unread_count_url: String =
        "/chat/unread_count?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_chat_image_upload_url: String =
        "/chat/chat_image_upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_chat_image_delete_url: String =
        "/chat/chat_image_delete?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_shipping_method_url: String =
        "/shippings/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_news_feed_url: String =
        "/feeds/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    //  String ps_category_url = "rest/categories/get?language_symbol=" + (localStorage.activeLanguage ? localStorage.activeLanguage : 'en');

    static ps_subCategory_url: String =
        "/subcategories/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_subCategory_subscription_url: String =
        "/subcat_subscribe/subcategory_subscribe?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_home_bunner_url: String =
        "/banners/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_manufacturer_url: String =
        "/manufacturers/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_model_url: String =
        "/models/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_transmission_url: String =
        "/transmissions/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_color_url: String =
        "/colors/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_fuel_type_url: String =
        "/fueltypes/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_build_type_url: String =
        "/bodystyles/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_seller_type_url: String =
        "/sellertypes/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_state_url: String =
        "/states/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_vehicle_type_url: String =
        "/vehicle_types/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_contact_us_url: String =
        "/contact?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_image_upload_url: String =
        "/images/upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_image_dropzone_upload_url: String =
        "/dropzone_images/upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_image_upload_url: String =
        "/user/user_image_upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_certificate_upload_url: String =
        "/images/upload_certificate?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_video_upload_url: String =
        "/product/video/upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_video_thumb_upload_url: String =
        "/product/icon/upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_dealership_upload_url: String =
        "/images/upload_certificate?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_image_upload_url: String =
        "/product/cover/upload?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_collection_url: String =
        "/collections/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_all_collection_url: String =
        "/products/all_collection_products?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_app_info_url: String =
        "/app_info?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_register_url: String =
        "/user/register?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_exist_user_url: String =
        "/existuser?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_create_user_url: String =
        "/CreateUser?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_email_verify_url: String =
        "/user/verify_code?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_code_verify_url: String =
        "/user/forgot_password_verify?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_add_bidding: String =
        "/biddings/add?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    // static  ps_offer_url :String ="/chats/offer_list?language_symbol=" + (localStorage.activeLanguage ? localStorage.activeLanguage : 'en');

    static ps_offline_payment_method_url: String =
        "/offline_payment?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /***Feb17 wallet*/
    static wallet_recharge_url: String =
        "/wallet_recharge?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /****** Wallet deduction API Feb27 ******************/
    static wallet_payment_url: String =
        "/wallet_payment?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static stripe_token_url: String =
        "/stripe_token?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static wallet_withdrawal: String =
        "/refund_amount?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static wallet_withdrawal_stripe: String =
        "/refund_stripe_amount?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /****** Wallet deduction API ends here************/
    static wallet_refund: String =
        "/withdraw_amount?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /*****************bid details api */

    static bid_wallet_payment_url: String =
        "/bid_placed_wallet_payment?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static seller_accepted_bid_url: string =
        "/seller_bid_accepted?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static seller_rejected_bid_url: string =
        "/seller_rejects_bid?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static get_bid_details: String =
        "/get_bid_details?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    //March 21
    static get_chat_bid_details: String =
        "/get_chat_bid_details?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /* ********** start April 04 ************ */
    static update_bid_status_url: String =
        "/update_bid_status?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static get_dispute_section_bids: String =
        "/disputable_bids?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static get_disputed_refund_bid_details: String =
        "/disputed_refund_bid_details?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static raise_buyer_dispute_url: String =
        "/raise_dispute?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_buyer_bids_url: String =
        "/get_buyer_bid_details?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_product_bids_api_url: String =
        "/get_product_bids?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_buyer_bid_and_history_url: String =
        "/get_buyer_bid_items_and_history?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");
    /* **********  end April 04 ************ */

    static ps_post_ps_zone_shipping_method_url: String =
        "/shipping_zones/get_shipping_cost?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_login_url: String =
        "/users/login?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_forgot_password_url: String =
        "/user/forgot_password?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_seller_credit_care_url: String =
        "/transaction_payments/add?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_credit_card_update_url: String =
        "/transaction_payments/update_card_info?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_report_item_url: String =
        "/complaint_item?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_change_password_url: String =
        "/user/update_password?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_reset_password_url: String =
        "/user/update_forgot_password?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_user_update_profile_url: String =
        "/user/profile_update?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_phone_login_url: String =
        "/users/phone_register?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_fb_login_url: String =
        "/users/facebook_register?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_google_login_url: String =
        "/users/google_register?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_apple_login_url: String =
        "/users/apple_register?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_resend_code_url: String =
        "/user/request_code?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_post_ps_touch_count_url: String =
        "/touch/item_touch?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_product_url: String =
        "/items/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_reorder_image_url: String =
        "/images/reorder_image?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_add_membership_url: String =
        "/members/add?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_products_search_url: String =
        "/products/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_url: String =
        "/user/get_detail?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /************feb 21 wallet ***********/
    static ps_user_wallet_url: String =
        "/user/get_wallet?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    /****************************************************** */
    static ps_user_stripe_connect: String =
        "/stripe_connect_dashboard?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");
    static ps_user_stripe_connect_payments: String =
        "/stripe_connect_payments?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_stripe_connect_url: String =
        "/onboard_users_on_connect?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_wallet_withdrawal_list_url: String =
        "/get_all_withdrawal_requests?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_url: String =
        "/push_noti_message/all_notis?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_mark_as_read_url: String =
        "/push_noti_read_user/is_read?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_mark_as_unread_url: String =
        "/push_noti_read_user/is_unread?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_delete_url: String =
        "/push_noti_read_user/destroy?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_bloglist_url: String =
        "/blog/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_blog_url: String =
        "/blog/detail?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_notidetail_url: String =
        "/push_noti_message/get_detail?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_transactionList_url: String =
        "/transactionheaders/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_transactionDetail_url: String =
        "/transactiondetails/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_shipping_country_url: String =
        "/shipping_zones/get_shipping_country?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_shipping_city_url: String =
        "/shipping_zones/get_shipping_city/ ?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_relatedProduct_url: String =
        "/products/related_product_trending?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_commentList_url: String =
        "/commentheaders/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_commentDetail_url: String =
        "/commentdetails/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_commentHeaderPost_url: String =
        "/commentheaders/press?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_commentDetailPost_url: String =
        "/commentdetails/press?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_downloadProductPost_url: String =
        "/downloads/download_product?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_register_url: String =
        "/push_noti_token/register_noti?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_delete_user_url: String =
        "/user/delete_user?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_chat_noti_url: String =
        "/notis/send_chat_noti?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_post_url: String =
        "/notis/is_read?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_noti_unregister_url: String =
        "/push_noti_token/unregister_noti?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_ratingPost_url: String =
        "/rating?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_ratingList_url: String =
        "/rating/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_favouritePost_url: String =
        "/favourite/item_favourite?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_favouriteList_url: String =
        "/favourite/get_favourite?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_selling_bid_item_url: String =
        "/biddings/get_seller_bid_approved?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_active_selling_bid_item_url: String =
        "/biddings/get_seller_to_do?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_buying_bid_item_url: String =
        "/biddings/get_buyer_bid_approved?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_active_buying_bid_item_url: String =
        "/biddings/get_buyer_to_do?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    //   static  ps_gallery_url : String = "/images/get_item_gallery?language_symbol=" + (localStorage.activeLanguage ? localStorage.activeLanguage : 'en');
    static ps_gallery_url: String =
        "/product/gallery_list?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_delete_image_url: String =
        "/product/delete_image?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_delete_video_url: String =
        "/product/delete_video_and_icon?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_couponDiscount_url: String =
        "/coupons/check?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_token_url: String =
        "/paypal/token?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_collection_product_url: String =
        "/products/all_collection_products?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_location_url: String =
        "/location-city/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_sub_location_url: String =
        "/item_location_townships/search?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_list_from_followers_url: String =
        "/items/get_item_by_followuser?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_paid_ad_item_list_url: String =
        "/paid_item?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_entry_url: String =
        "/product?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_type_url: String =
        "/itemtypes/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_condition_url: String =
        "/conditions/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_price_type_url: String =
        "/pricetypes/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_currency_type_url: String =
        "/currency?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_deal_option_url: String =
        "/options/get?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_promotion_entry_url: String =
        "/paid_item?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_bidding_stripe_url: String =
        "/bidding_transactions/add?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_approve_reject_bidding_url: String =
        "/biddings/bidding_approval_reject?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_update_end_time_url: String =
        "/biddings/update_start_time?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_item_delete_url: String =
        "/product/delete_item?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_logout_url: String =
        "/users/logout?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_user_dealership_cancel_url: String =
        "/users/dealership_cancel?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_offer_list_url: String = "/chat/get_offer_list?";

    static ps_submit_vendor_application: String =
        "/vendor_application/submit?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_vendor_list_url: String =
        "/vendor/get_vendors?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_vendor_detail_url: String =
        "/vendor/get_vendor?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_vendor_branches_url: String =
        "/vendor/get_vendor_branches?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static ps_update_auction_item_status_url: string =
        "/product/update_auction_status?language_symbol" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static buy_it_now_url: String =
        "/buy_it_now?language_symbol" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");
    static buy_it_now_stripe_url: String =
        "/buy_it_now_stripe?language_symbol" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static bid_placed_by_user_url: string =
        "/bid_placed_by_user?language_symbol" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static live_productDetail_url: string =
        "/product/get_live_product?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");

    static sale_purchase_history_url: string =
        "/sale_purchase_history?language_symbol=" +
        (localStorage.activeLanguage ? localStorage.activeLanguage : "en");
}
