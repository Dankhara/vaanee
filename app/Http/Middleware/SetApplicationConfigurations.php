<?php

namespace App\Http\Middleware;

use App\Models\ApplicationConfiguration;
use Closure;
use Illuminate\Http\Request;

class SetApplicationConfigurations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $applicationConfigurations = cache('application_configurations');
        if (!isset($applicationConfigurations)) {
            $applicationConfigurations = ApplicationConfiguration::query()
                ->pluck('configuration_value', 'configuration_key')
                ->toArray();
            cache(['application_configurations' => $applicationConfigurations]);
        }
        if (isset($applicationConfigurations) && count($applicationConfigurations) > 0) {
            config([
                //app
                'app.email' => ($applicationConfigurations['APP_EMAIL']) ?? env('APP_EMAIL'),
                'app.timezone' => ($applicationConfigurations['APP_TIMEZONE']) ?? env('APP_TIMEZONE'),

                //tts.php
                'tts.enable.aws' => ($applicationConfigurations['CONFIG_ENABLE_AWS']) ?? env('CONFIG_ENABLE_AWS'),
                'tts.enable.aws_standard' => ($applicationConfigurations['CONFIG_ENABLE_AWS_STANDARD']) ?? env('CONFIG_ENABLE_AWS_STANDARD'),
                'tts.enable.aws_neural' => ($applicationConfigurations['CONFIG_ENABLE_AWS_NEURAL']) ?? env('CONFIG_ENABLE_AWS_NEURAL'),
                'tts.enable.azure' => ($applicationConfigurations['CONFIG_ENABLE_AZURE']) ?? env('CONFIG_ENABLE_AZURE'),
                'tts.enable.azure_standard' => ($applicationConfigurations['CONFIG_ENABLE_AZURE_STANDARD']) ?? env('CONFIG_ENABLE_AZURE_STANDARD'),
                'tts.enable.azure_neural' => ($applicationConfigurations['CONFIG_ENABLE_AZURE_NEURAL']) ?? env('CONFIG_ENABLE_AZURE_NEURAL'),
                'tts.enable.gcp' => ($applicationConfigurations['CONFIG_ENABLE_GCP']) ?? env('CONFIG_ENABLE_GCP'),
                'tts.enable.gcp_standard' => ($applicationConfigurations['CONFIG_ENABLE_GCP_STANDARD']) ?? env('CONFIG_ENABLE_GCP_STANDARD'),
                'tts.enable.gcp_neural' => ($applicationConfigurations['CONFIG_ENABLE_GCP_NEURAL']) ?? env('CONFIG_ENABLE_GCP_NEURAL'),
                'tts.enable.ibm' => ($applicationConfigurations['CONFIG_ENABLE_IBM']) ?? env('CONFIG_ENABLE_IBM'),
                'tts.enable.sound_studio' => array_key_exists('CONFIG_ENABLE_SOUND_STUDIO', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_SOUND_STUDIO'] : env('CONFIG_ENABLE_SOUND_STUDIO'),
                //frontend
                'tts.frontend.status' => array_key_exists('CONFIG_FRONTEND_LIVE_SYNTHESIZE', $applicationConfigurations) ? $applicationConfigurations['CONFIG_FRONTEND_LIVE_SYNTHESIZE'] : env('CONFIG_FRONTEND_LIVE_SYNTHESIZE'),
                'tts.frontend.max_chars' => ($applicationConfigurations['CONFIG_FRONTEND_MAX_CHAR_LIMIT']) ?? env('CONFIG_FRONTEND_MAX_CHAR_LIMIT'),
                'tts.frontend.neural' => ($applicationConfigurations['CONFIG_FRONTEND_NEURAL_VOICES']) ?? env('CONFIG_FRONTEND_NEURAL_VOICES', 'disable'),

                'tts.voice_type' => ($applicationConfigurations['CONFIG_VOICE_TYPE']) ?? env('CONFIG_VOICE_TYPE', 'both'),
                'tts.ssml_effect' => ($applicationConfigurations['CONFIG_SSML_EFFECT']) ?? env('CONFIG_SSML_EFFECT', 'enable'),
                'tts.max_chars_limit' => ($applicationConfigurations['CONFIG_MAX_CHAR_LIMIT']) ?? env('CONFIG_MAX_CHAR_LIMIT', 3000),
                'tts.max_voice_limit' => ($applicationConfigurations['CONFIG_MAX_VOICE_LIMIT']) ?? env('CONFIG_MAX_VOICE_LIMIT', 5),
                'tts.max_voice_limit_user' => ($applicationConfigurations['CONFIG_MAX_VOICE_LIMIT_USER']) ?? env('CONFIG_MAX_VOICE_LIMIT_USER', 5),
                'tts.free_chars_limit' => ($applicationConfigurations['CONFIG_MAX_FREE_TIER_CHAR_LIMIT']) ?? env('CONFIG_MAX_FREE_TIER_CHAR_LIMIT', 1000),
                'tts.free_chars' => ($applicationConfigurations['CONFIG_MAX_FREE_CHARS']) ?? env('CONFIG_MAX_FREE_CHARS', 0),
                'tts.default_storage' => ($applicationConfigurations['CONFIG_DEFAULT_STORAGE']) ?? env('CONFIG_DEFAULT_STORAGE', 'local'),
                'tts.clean_storage' => ($applicationConfigurations['CONFIG_CLEAN_STORAGE']) ?? env('CONFIG_CLEAN_STORAGE', 'never'),
                'tts.user_neural' => ($applicationConfigurations['CONFIG_USER_NEURAL_VOICES']) ?? env('CONFIG_USER_NEURAL_VOICES', 'disable'),
                'tts.vendor_logos' => ($applicationConfigurations['CONFIG_VENDOR_LOGOS']) ?? env('CONFIG_VENDOR_LOGOS', 'show'),
                'tts.default_language' => ($applicationConfigurations['CONFIG_DEFAULT_LANGUAGE']) ?? env('CONFIG_DEFAULT_LANGUAGE'),
                'tts.default_voice' => ($applicationConfigurations['CONFIG_DEFAULT_VOICE']) ?? env('CONFIG_DEFAULT_VOICE'),
                'tts.listen_download' => ($applicationConfigurations['CONFIG_LISTEN_DOWNLOAD']) ?? env('CONFIG_LISTEN_DOWNLOAD'),
                'tts.max_background_audio_size' => ($applicationConfigurations['CONFIG_MAX_BACKGROUND_AUDIO_SIZE']) ?? env('CONFIG_MAX_BACKGROUND_AUDIO_SIZE'),
                'tts.max_merge_files' => ($applicationConfigurations['CONFIG_MAX_MERGE_FILES']) ?? env('CONFIG_MAX_MERGE_FILES'),
                'tts.windows_ffmpeg_path' => ($applicationConfigurations['CONFIG_WINDOWS_FFMPEG_PATH']) ?? env('CONFIG_WINDOWS_FFMPEG_PATH'),
                'tts.voice_over_studio_multiplier' => ($applicationConfigurations['VOICE_OVER_STUDIO_MULTIPLIER']) ?? env('VOICE_OVER_STUDIO_MULTIPLIER', 1),
                'tts.video_dub_studio_multiplier' => ($applicationConfigurations['VIDEO_DUB_STUDIO_MULTIPLIER']) ?? env('VIDEO_DUB_STUDIO_MULTIPLIER', 5),
                'tts.audio_dub_studio_multiplier' => ($applicationConfigurations['AUDIO_DUB_STUDIO_MULTIPLIER']) ?? env('AUDIO_DUB_STUDIO_MULTIPLIER', 3),

                //cache.php
                'cache.stores.dynamodb.key' => ($applicationConfigurations['AWS_ACCESS_KEY_ID']) ?? env('AWS_ACCESS_KEY_ID'),
                'cache.stores.dynamodb.secret' => ($applicationConfigurations['AWS_SECRET_ACCESS_KEY']) ?? env('AWS_SECRET_ACCESS_KEY'),
                'cache.stores.dynamodb.region' => ($applicationConfigurations['AWS_DEFAULT_REGION']) ?? env('AWS_DEFAULT_REGION', 'us-east-1'),

                //file systems
                'filesystems.disks.s3.key' => ($applicationConfigurations['AWS_ACCESS_KEY_ID']) ?? env('AWS_ACCESS_KEY_ID'),
                'filesystems.disks.s3.secret' => ($applicationConfigurations['AWS_SECRET_ACCESS_KEY']) ?? env('AWS_SECRET_ACCESS_KEY'),
                'filesystems.disks.s3.region' => ($applicationConfigurations['AWS_DEFAULT_REGION']) ?? env('AWS_DEFAULT_REGION'),
                'filesystems.disks.s3.bucket' => ($applicationConfigurations['AWS_BUCKET']) ?? env('AWS_BUCKET'),

                //queue
                'queue.connections.sqs.key' => ($applicationConfigurations['AWS_ACCESS_KEY_ID']) ?? env('AWS_ACCESS_KEY_ID'),

                //services
                'services.ses.key' => ($applicationConfigurations['AWS_ACCESS_KEY_ID']) ?? env('AWS_ACCESS_KEY_ID'),
                'services.ses.secret' => ($applicationConfigurations['AWS_SECRET_ACCESS_KEY']) ?? env('AWS_SECRET_ACCESS_KEY'),
                'services.ses.region' => ($applicationConfigurations['AWS_DEFAULT_REGION']) ?? env('AWS_DEFAULT_REGION', 'us-east-1'),
                'services.aws.key' => ($applicationConfigurations['AWS_ACCESS_KEY_ID']) ?? env('AWS_ACCESS_KEY_ID'),
                'services.aws.secret' => ($applicationConfigurations['AWS_SECRET_ACCESS_KEY']) ?? env('AWS_SECRET_ACCESS_KEY'),
                'services.aws.region' => ($applicationConfigurations['AWS_DEFAULT_REGION']) ?? env('AWS_DEFAULT_REGION', 'us-east-1'),
                'services.aws.bucket' => ($applicationConfigurations['AWS_BUCKET']) ?? env('AWS_BUCKET'),
                'services.azure.key' => ($applicationConfigurations['AZURE_SUBSCRIPTION_KEY']) ?? env('AZURE_SUBSCRIPTION_KEY'),
                'services.azure.region' => ($applicationConfigurations['AZURE_DEFAULT_REGION']) ?? env('AZURE_DEFAULT_REGION'),
                'services.gcp.key_path' => ($applicationConfigurations['GOOGLE_APPLICATION_CREDENTIALS']) ?? env('GOOGLE_APPLICATION_CREDENTIALS'),
                'services.gcp.bucket' => ($applicationConfigurations['GOOGLE_STORAGE_BUCKET']) ?? env('GOOGLE_STORAGE_BUCKET'),
                'services.ibm.api_key' => ($applicationConfigurations['IBM_API_KEY']) ?? env('IBM_API_KEY'),
                'services.ibm.endpoint_url' => ($applicationConfigurations['IBM_ENDPOINT_URL']) ?? env('IBM_ENDPOINT_URL'),
                'services.paypal.enable' => array_key_exists('PAYPAL_ENABLED', $applicationConfigurations) ? $applicationConfigurations['PAYPAL_ENABLED'] : env('PAYPAL_ENABLED'),
                'services.paypal.subscription_enable' => array_key_exists('PAYPAL_SUBSCRIPTION_ENABLED', $applicationConfigurations) ? $applicationConfigurations['PAYPAL_SUBSCRIPTION_ENABLED'] : env('PAYPAL_SUBSCRIPTION_ENABLED'),
                'services.paypal.base_uri' => ($applicationConfigurations['PAYPAL_BASE_URI']) ?? env('PAYPAL_BASE_URI'),
                'services.paypal.webhook_uri' => ($applicationConfigurations['PAYPAL_WEBHOOK_URI']) ?? env('PAYPAL_WEBHOOK_URI'),
                'services.paypal.webhook_id' => ($applicationConfigurations['PAYPAL_WEBHOOK_ID']) ?? env('PAYPAL_WEBHOOK_ID'),
                'services.paypal.client_id' => ($applicationConfigurations['PAYPAL_CLIENT_ID']) ?? env('PAYPAL_CLIENT_ID'),
                'services.paypal.client_secret' => ($applicationConfigurations['PAYPAL_CLIENT_SECRET']) ?? env('PAYPAL_CLIENT_SECRET'),
                'services.stripe.enable' => array_key_exists('STRIPE_ENABLED', $applicationConfigurations) ? $applicationConfigurations['STRIPE_ENABLED'] : env('STRIPE_ENABLED'),
                'services.stripe.subscription_enable' => array_key_exists('STRIPE_SUBSCRIPTION_ENABLED', $applicationConfigurations) ? $applicationConfigurations['STRIPE_SUBSCRIPTION_ENABLED'] : env('STRIPE_SUBSCRIPTION_ENABLED'),
                'services.stripe.base_uri' => ($applicationConfigurations['STRIPE_BASE_URI']) ?? env('STRIPE_BASE_URI'),
                'services.stripe.webhook_uri' => ($applicationConfigurations['STRIPE_WEBHOOK_URI']) ?? env('STRIPE_WEBHOOK_URI'),
                'services.stripe.webhook_secret' => ($applicationConfigurations['STRIPE_WEBHOOK_SECRET']) ?? env('STRIPE_WEBHOOK_SECRET'),
                'services.stripe.api_key' => ($applicationConfigurations['STRIPE_KEY']) ?? env('STRIPE_KEY'),
                'services.stripe.api_secret' => ($applicationConfigurations['STRIPE_SECRET']) ?? env('STRIPE_SECRET'),
                'services.paystack.enable' => array_key_exists('PAYSTACK_ENABLED', $applicationConfigurations) ? $applicationConfigurations['PAYSTACK_ENABLED'] : env('PAYSTACK_ENABLED'),
                'services.paystack.subscription_enable' => array_key_exists('PAYSTACK_SUBSCRIPTION_ENABLED', $applicationConfigurations) ? $applicationConfigurations['PAYSTACK_SUBSCRIPTION_ENABLED'] : env('PAYSTACK_SUBSCRIPTION_ENABLED'),
                'services.paystack.base_uri' => ($applicationConfigurations['PAYSTACK_BASE_URI']) ?? env('PAYSTACK_BASE_URI'),
                'services.paystack.webhook_uri' => ($applicationConfigurations['PAYSTACK_WEBHOOK_URI']) ?? env('PAYSTACK_WEBHOOK_URI'),
                'services.paystack.api_key' => ($applicationConfigurations['PAYSTACK_PUBLIC_KEY']) ?? env('PAYSTACK_PUBLIC_KEY'),
                'services.paystack.api_secret' => ($applicationConfigurations['PAYSTACK_SECRET_KEY']) ?? env('PAYSTACK_SECRET_KEY'),
                'services.razorpay.enable' => array_key_exists('RAZORPAY_ENABLED', $applicationConfigurations) ? $applicationConfigurations['RAZORPAY_ENABLED'] : env('RAZORPAY_ENABLED'),
                'services.razorpay.subscription_enable' => array_key_exists('RAZORPAY_SUBSCRIPTION_ENABLED', $applicationConfigurations) ? $applicationConfigurations['RAZORPAY_SUBSCRIPTION_ENABLED'] : env('RAZORPAY_SUBSCRIPTION_ENABLED'),
                'services.razorpay.base_uri' => ($applicationConfigurations['RAZORPAY_BASE_URI']) ?? env('RAZORPAY_BASE_URI'),
                'services.razorpay.webhook_uri' => ($applicationConfigurations['RAZORPAY_WEBHOOK_URI']) ?? env('RAZORPAY_WEBHOOK_URI'),
                'services.razorpay.webhook_secret' => ($applicationConfigurations['RAZORPAY_WEBHOOK_SECRET']) ?? env('RAZORPAY_WEBHOOK_SECRET'),
                'services.razorpay.key_id' => ($applicationConfigurations['RAZORPAY_KEY_ID']) ?? env('RAZORPAY_KEY_ID'),
                'services.razorpay.key_secret' => ($applicationConfigurations['RAZORPAY_KEY_SECRET']) ?? env('RAZORPAY_KEY_SECRET'),
                'services.mollie.enable' => array_key_exists('MOLLIE_ENABLED', $applicationConfigurations) ? $applicationConfigurations['MOLLIE_ENABLED'] : env('MOLLIE_ENABLED'),
                'services.mollie.subscription_enable' => array_key_exists('MOLLIE_SUBSCRIPTION_ENABLED', $applicationConfigurations) ? $applicationConfigurations['MOLLIE_SUBSCRIPTION_ENABLED'] : env('MOLLIE_SUBSCRIPTION_ENABLED'),
                'services.mollie.base_uri' => ($applicationConfigurations['MOLLIE_BASE_URI']) ?? env('MOLLIE_BASE_URI'),
                'services.mollie.webhook_uri' => ($applicationConfigurations['MOLLIE_WEBHOOK_URI']) ?? env('MOLLIE_WEBHOOK_URI'),
                'services.mollie.key_id' => ($applicationConfigurations['MOLLIE_KEY_ID']) ?? env('MOLLIE_KEY_ID'),
                'services.braintree.enable' => array_key_exists('BRAINTREE_ENABLED', $applicationConfigurations) ? $applicationConfigurations['BRAINTREE_ENABLED'] : env('BRAINTREE_ENABLED'),
                'services.braintree.env' => ($applicationConfigurations['BRAINTREE_ENV']) ?? env('BRAINTREE_ENV'),
                'services.braintree.merchant_id' => ($applicationConfigurations['BRAINTREE_MERCHANT_ID']) ?? env('BRAINTREE_MERCHANT_ID'),
                'services.braintree.private_key' => ($applicationConfigurations['BRAINTREE_PRIVATE_KEY']) ?? env('BRAINTREE_PRIVATE_KEY'),
                'services.braintree.public_key' => ($applicationConfigurations['BRAINTREE_PUBLIC_KEY']) ?? env('BRAINTREE_PUBLIC_KEY'),
                'services.coinbase.enable' => array_key_exists('COINBASE_ENABLED', $applicationConfigurations) ? $applicationConfigurations['COINBASE_ENABLED'] : env('COINBASE_ENABLED'),
                'services.coinbase.webhook_uri' => ($applicationConfigurations['COINBASE_WEBHOOK_URI']) ?? env('COINBASE_WEBHOOK_URI'),
                'services.coinbase.webhook_secret' => ($applicationConfigurations['COINBASE_WEBHOOK_SECRET']) ?? env('COINBASE_WEBHOOK_SECRET'),
                'services.coinbase.api_key' => ($applicationConfigurations['COINBASE_API_KEY']) ?? env('COINBASE_API_KEY'),
                'services.banktransfer.prepaid' => array_key_exists('BANK_TRANSFER_PREPAID', $applicationConfigurations) ? $applicationConfigurations['BANK_TRANSFER_PREPAID'] : env('BANK_TRANSFER_PREPAID'),
                'services.banktransfer.subscription' => array_key_exists('BANK_TRANSFER_SUBSCRIPTION', $applicationConfigurations) ? $applicationConfigurations['BANK_TRANSFER_SUBSCRIPTION'] : env('BANK_TRANSFER_SUBSCRIPTION'),
                'services.google.recaptcha.enable' => array_key_exists('GOOGLE_RECAPTCHA_ENABLE', $applicationConfigurations) ? $applicationConfigurations['GOOGLE_RECAPTCHA_ENABLE'] : env('GOOGLE_RECAPTCHA_ENABLE'),
                'services.google.recaptcha.site_key' => ($applicationConfigurations['GOOGLE_RECAPTCHA_SITE_KEY']) ?? env('GOOGLE_RECAPTCHA_SITE_KEY'),
                'services.google.recaptcha.secret_key' => ($applicationConfigurations['GOOGLE_RECAPTCHA_SECRET_KEY']) ?? env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                'services.google.maps.enable' => array_key_exists('GOOGLE_MAPS_ENABLE', $applicationConfigurations) ? $applicationConfigurations['GOOGLE_MAPS_ENABLE'] : env('GOOGLE_MAPS_ENABLE'),
                'services.google.maps.key' => ($applicationConfigurations['GOOGLE_MAPS_KEY']) ?? env('GOOGLE_MAPS_KEY'),
                'services.google.analytics.enable' => array_key_exists('GOOGLE_ANALYTICS_ENABLE', $applicationConfigurations) ? $applicationConfigurations['GOOGLE_ANALYTICS_ENABLE'] : env('GOOGLE_ANALYTICS_ENABLE'),
                'services.google.analytics.id' => ($applicationConfigurations['GOOGLE_ANALYTICS_ID']) ?? env('GOOGLE_ANALYTICS_ID'),
                'services.facebook.enable' => array_key_exists('CONFIG_ENABLE_LOGIN_FACEBOOK', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_LOGIN_FACEBOOK'] : env('CONFIG_ENABLE_LOGIN_FACEBOOK'),
                'services.facebook.client_id' => ($applicationConfigurations['FACEBOOK_API_KEY']) ?? env('FACEBOOK_API_KEY'),
                'services.facebook.client_secret' => ($applicationConfigurations['FACEBOOK_API_SECRET']) ?? env('FACEBOOK_API_SECRET'),
                'services.facebook.redirect' => ($applicationConfigurations['FACEBOOK_REDIRECT']) ?? env('FACEBOOK_REDIRECT'),
                'services.twitter.enable' => array_key_exists('CONFIG_ENABLE_LOGIN_TWITTER', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_LOGIN_TWITTER'] : env('CONFIG_ENABLE_LOGIN_TWITTER'),
                'services.twitter.client_id' => ($applicationConfigurations['TWITTER_API_KEY']) ?? env('TWITTER_API_KEY'),
                'services.twitter.client_secret' => ($applicationConfigurations['TWITTER_API_SECRET']) ?? env('TWITTER_API_SECRET'),
                'services.twitter.redirect' => ($applicationConfigurations['TWITTER_REDIRECT']) ?? env('TWITTER_REDIRECT'),
                'services.linkedin.enable' => array_key_exists('CONFIG_ENABLE_LOGIN_LINKEDIN', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_LOGIN_LINKEDIN'] : env('CONFIG_ENABLE_LOGIN_LINKEDIN'),
                'services.linkedin.client_id' => ($applicationConfigurations['LINKEDIN_API_KEY']) ?? env('LINKEDIN_API_KEY'),
                'services.linkedin.client_secret' => ($applicationConfigurations['LINKEDIN_API_SECRET']) ?? env('LINKEDIN_API_SECRET'),
                'services.linkedin.redirect' => ($applicationConfigurations['LINKEDIN_REDIRECT']) ?? env('LINKEDIN_REDIRECT'),
                'services.google.enable' => array_key_exists('CONFIG_ENABLE_LOGIN_GOOGLE', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_LOGIN_GOOGLE'] : env('CONFIG_ENABLE_LOGIN_GOOGLE'),
                'services.google.client_id' => ($applicationConfigurations['GOOGLE_API_KEY']) ?? env('GOOGLE_API_KEY'),
                'services.google.client_secret' => ($applicationConfigurations['GOOGLE_API_SECRET']) ?? env('GOOGLE_API_SECRET'),
                'services.google.redirect' => ($applicationConfigurations['GOOGLE_REDIRECT']) ?? env('GOOGLE_REDIRECT'),

                //stt
                'stt.enable.aws' => array_key_exists('CONFIG_ENABLE_AWS_AUDIO', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_AWS_AUDIO'] : env('CONFIG_ENABLE_AWS_AUDIO'),
                'stt.enable.aws_live' => array_key_exists('CONFIG_ENABLE_AWS_AUDIO_LIVE', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_AWS_AUDIO_LIVE'] : env('CONFIG_ENABLE_AWS_AUDIO_LIVE'),
                'stt.enable.gcp' => array_key_exists('CONFIG_ENABLE_GCP_AUDIO', $applicationConfigurations) ? $applicationConfigurations['CONFIG_ENABLE_GCP_AUDIO'] : env('CONFIG_ENABLE_GCP_AUDIO'),
                'stt.language.file' => ($applicationConfigurations['CONFIG_DEFAULT_LANGUAGE_FILE']) ?? env('CONFIG_DEFAULT_LANGUAGE_FILE'),
                'stt.language.live' => ($applicationConfigurations['CONFIG_DEFAULT_LANGUAGE_LIVE']) ?? env('CONFIG_DEFAULT_LANGUAGE_LIVE'),
                'stt.file_format' => ($applicationConfigurations['CONFIG_FILE_FORMAT']) ?? env('CONFIG_FILE_FORMAT'),
                'stt.max_size_limit' => ($applicationConfigurations['CONFIG_MAX_SIZE_LIMIT']) ?? env('CONFIG_MAX_SIZE_LIMIT', 10),
                'stt.max_length_limit_file' => ($applicationConfigurations['CONFIG_MAX_LENGTH_LIMIT_FILE']) ?? env('CONFIG_MAX_LENGTH_LIMIT_FILE', 5),
                'stt.max_length_limit_live' => ($applicationConfigurations['CONFIG_MAX_LENGTH_LIMIT_LIVE']) ?? env('CONFIG_MAX_LENGTH_LIMIT_LIVE', 5),
                'stt.max_length_limit_file_none' => ($applicationConfigurations['CONFIG_MAX_LENGTH_LIMIT_FILE_NONE']) ?? env('CONFIG_MAX_LENGTH_LIMIT_FILE_NONE', 5),
                'stt.max_length_limit_live_none' => ($applicationConfigurations['CONFIG_MAX_LENGTH_LIMIT_LIVE_NONE']) ?? env('CONFIG_MAX_LENGTH_LIMIT_LIVE_NONE', 5),
                'stt.free_minutes' => ($applicationConfigurations['CONFIG_FREE_MINUTES']) ?? env('CONFIG_FREE_MINUTES', 5),
                'stt.vendor_logos' => ($applicationConfigurations['CONFIG_VENDOR_LOGOS']) ?? env('CONFIG_VENDOR_LOGOS', 'show'),
                'stt.speaker_identification' => ($applicationConfigurations['CONFIG_SPEAKER_IDENTIFICATION']) ?? env('CONFIG_SPEAKER_IDENTIFICATION'),

                //payment
                'payment.payment_option' => ($applicationConfigurations['PAYMENT_OPTION']) ?? env('PAYMENT_OPTION'),
                'payment.payment_tax' => ($applicationConfigurations['PAYMENT_TAX']) ?? env('PAYMENT_TAX'),
                'payment.default_system_currency' => ($applicationConfigurations['DEFAULT_SYSTEM_CURRENCY']) ?? env('DEFAULT_SYSTEM_CURRENCY', 'USD'),
                'payment.default_system_currency_symbol' => ($applicationConfigurations['DEFAULT_SYSTEM_CURRENCY_SYMBOL']) ?? env('DEFAULT_SYSTEM_CURRENCY_SYMBOL', '&#36;'),
                'payment.default_invoice_currency' => ($applicationConfigurations['DEFAULT_INVOICE_CURRENCY']) ?? env('DEFAULT_INVOICE_CURRENCY', 'USD'),

                //frontend
                'frontend.maintenance' => array_key_exists('FRONTEND_MAINTENANCE_MODE', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_MAINTENANCE_MODE'] : env('FRONTEND_MAINTENANCE_MODE'),
                'frontend.frontend_page' => array_key_exists('FRONTEND_FRONTEND_PAGE', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_FRONTEND_PAGE'] : env('FRONTEND_FRONTEND_PAGE'),
                'frontend.pricing_section' => array_key_exists('FRONTEND_PRICING_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_PRICING_SECTION'] : env('FRONTEND_PRICING_SECTION'),
                'frontend.features_section' => array_key_exists('FRONTEND_FEATURES_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_FEATURES_SECTION'] : env('FRONTEND_FEATURES_SECTION'),
                'frontend.cases_section' => array_key_exists('FRONTEND_CASES_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_CASES_SECTION'] : env('FRONTEND_CASES_SECTION'),
                'frontend.voices_section' => array_key_exists('FRONTEND_VOICES_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_VOICES_SECTION'] : env('FRONTEND_VOICES_SECTION'),
                'frontend.reviews_section' => array_key_exists('FRONTEND_REVIEWS_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_REVIEWS_SECTION'] : env('FRONTEND_REVIEWS_SECTION'),
                'frontend.blogs_section' => array_key_exists('FRONTEND_BLOGS_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_BLOGS_SECTION'] : env('FRONTEND_BLOGS_SECTION'),
                'frontend.faq_section' => array_key_exists('FRONTEND_FAQ_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_FAQ_SECTION'] : env('FRONTEND_FAQ_SECTION'),
                'frontend.contact_section' => array_key_exists('FRONTEND_CONTACT_SECTION', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_CONTACT_SECTION'] : env('FRONTEND_CONTACT_SECTION'),
                'frontend.custom_url.status' => array_key_exists('FRONTEND_CUSTOM_URL_STATUS', $applicationConfigurations) ? $applicationConfigurations['FRONTEND_CUSTOM_URL_STATUS'] : env('FRONTEND_CUSTOM_URL_STATUS'),
                'frontend.custom_url.link' => ($applicationConfigurations['FRONTEND_CUSTOM_URL_LINK']) ?? env('FRONTEND_CUSTOM_URL_LINK'),
                'frontend.social_twitter' => ($applicationConfigurations['FRONTEND_SOCIAL_TWITTER']) ?? env('FRONTEND_SOCIAL_TWITTER'),
                'frontend.social_facebook' => ($applicationConfigurations['FRONTEND_SOCIAL_FACEBOOK']) ?? env('FRONTEND_SOCIAL_FACEBOOK'),
                'frontend.social_linkedin' => ($applicationConfigurations['FRONTEND_SOCIAL_LINKEDIN']) ?? env('FRONTEND_SOCIAL_LINKEDIN'),
                'frontend.social_instagram' => ($applicationConfigurations['FRONTEND_SOCIAL_INSTAGRAM']) ?? env('FRONTEND_SOCIAL_INSTAGRAM'),

                //settings
                'settings.default_user' => ($applicationConfigurations['GENERAL_SETTINGS_DEFAULT_USER_GROUP']) ?? env('GENERAL_SETTINGS_DEFAULT_USER_GROUP'),
                'settings.support_email' => ($applicationConfigurations['GENERAL_SETTINGS_SUPPORT_EMAIL']) ?? env('GENERAL_SETTINGS_SUPPORT_EMAIL'),
                'settings.user_notification' => ($applicationConfigurations['GENERAL_SETTINGS_USER_NOTIFICATION']) ?? env('GENERAL_SETTINGS_USER_NOTIFICATION'),
                'settings.user_support' => ($applicationConfigurations['GENERAL_SETTINGS_USER_SUPPORT']) ?? env('GENERAL_SETTINGS_USER_SUPPORT'),
                'settings.oauth_login' => ($applicationConfigurations['GENERAL_SETTINGS_OAUTH_LOGIN']) ?? env('GENERAL_SETTINGS_OAUTH_LOGIN'),
                'settings.registration' => ($applicationConfigurations['GENERAL_SETTINGS_REGISTRATION']) ??  env('GENERAL_SETTINGS_REGISTRATION'),
                'settings.email_verification' => ($applicationConfigurations['GENERAL_SETTINGS_EMAIL_VERIFICATION']) ??  env('GENERAL_SETTINGS_EMAIL_VERIFICATION'),
                'settings.default_country' => ($applicationConfigurations['GENERAL_SETTINGS_DEFAULT_COUNTRY']) ??  env('GENERAL_SETTINGS_DEFAULT_COUNTRY'),

                //cookie-consent
                'cookie-consent.enabled' => ($applicationConfigurations['COOKIE_CONSENT_ENABLED']) ?? env('COOKIE_CONSENT_ENABLED', true),

                //mail
                'mail.mailers.smtp.host' => ($applicationConfigurations['MAIL_HOST']) ?? env('MAIL_HOST', 'smtp.mailgun.org'),
                'mail.mailers.smtp.port' => ($applicationConfigurations['MAIL_PORT']) ?? env('MAIL_PORT', 587),
                'mail.mailers.smtp.username' => ($applicationConfigurations['MAIL_USERNAME']) ?? env('MAIL_USERNAME'),
                'mail.mailers.smtp.password' => ($applicationConfigurations['MAIL_PASSWORD']) ?? env('MAIL_PASSWORD'),
                'mail.from.address' => ($applicationConfigurations['MAIL_FROM_ADDRESS']) ?? env('MAIL_FROM_ADDRESS', config('app.name')),
                'mail.from.name' => ($applicationConfigurations['MAIL_FROM_NAME']) ?? env('MAIL_FROM_NAME', config('app.name')),
                'mail.mailers.smtp.encryption' => ($applicationConfigurations['MAIL_ENCRYPTION']) ?? env('MAIL_ENCRYPTION', 'tls'),
            ]);
        }
        return $next($request);
    }
}
