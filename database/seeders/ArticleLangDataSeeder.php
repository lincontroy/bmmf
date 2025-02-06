<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleLangData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ArticleLangDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        ArticleLangData::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $articles = Article::all();

        foreach ($articles as $article) {
            $createData = $this->getCreateData($article, 1, null);
            ArticleLangData::insert($createData);
            $createData = $this->getCreateData($article, 2, " es");
            ArticleLangData::insert($createData);
        }

    }

    private function getCreateData($article, $languageId, $langText): array
    {
        $data = [];

        if ($article->slug == "header_menu") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "/",
                    "small_content" => "Home" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "packages",
                    "small_content" => "Packages" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "stake",
                    "small_content" => "Stake" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "merchant",
                    "small_content" => "Merchant" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x",
                    "small_content" => "B2X" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "quick-exchange",
                    "small_content" => "Quick Exchange" . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "footer_menu") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "about",
                    "small_content" => "About" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "contact",
                    "small_content" => "Contact" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "services",
                    "small_content" => "Services" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "blog",
                    "small_content" => "Blog" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "team-member",
                    "small_content" => "Team Member" . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "home_slider") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "home_slider_title",
                    "small_content" => "75% Save For the Black Friday Weekend " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "home_slider_header",
                    "small_content" => "Fastest & secure platform to invest in crypto " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "home_slider_para",
                    "small_content" => null,
                    "large_content" => "Buy and sell cryptocurrencies, trusted by 10M wallets with over $30 billion in transactions. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "home_about") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "about_header",
                    "small_content" => "About Our Company " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "about_title",
                    "small_content" => null,
                    "large_content" => "Innovative Business Solutions for Financial Company " . $article->id . $langText,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "about_content",
                    "small_content" => null,
                    "large_content" => "This method is suitable for paying for goods or services. You can set the price in a fiat currency so the payer chooses a cryptocurrency and pays a corresponding amount, or specify the preferable cryptocurrency right away, and the cryptocurrency address will be generated after choosing a network. " . $article->id . $langText,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "about_button_text",
                    "small_content" => "Get Started Now " . $article->id . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "merchant_title") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "merchant_title_header",
                    "small_content" => "Merchant Management " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "merchant_title_content",
                    "small_content" => null,
                    "large_content" => "Create your merchant account and get payment for you store. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "merchant_content") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "merchant_content_header",
                    "small_content" => null,
                    "large_content" => $article->article_name . ' ' . $article->id . $langText,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "merchant_content_body",
                    "small_content" => null,
                    "large_content" => "Specify your shop type and apply to upgrade your standard account to a merchant account. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "investment_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "investment_header_title",
                    "small_content" => "Investment Plan " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "investment_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "why_choose_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "why_choose_header_title",
                    "small_content" => "Why Choose Nishue " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "why_choose_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "satisfied_customer_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "satisfied_customer_header_title",
                    "small_content" => "Our Priority - Satisfied Customers, But Don't Take Our Word For It: " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "satisfied_customer_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "payment_we_accept_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "payment_we_accept_header_title",
                    "small_content" => "Payment We Accept " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "payment_we_accept_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "faq_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "faq_header_title",
                    "small_content" => "Frequently Asked Questions " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "faq_header_content",
                    "small_content" => null,
                    "large_content" => "We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please contact us. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "top_invest_ranking_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "top_invest_ranking_header_title",
                    "small_content" => "Our top Investor Ranking" . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "top_invest_ranking_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "why_choose_content") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "why_choose_content_header",
                    "small_content" => $article->article_name . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "why_choose_content_body",
                    "small_content" => null,
                    "large_content" => "Specify your shop type and apply to upgrade your standard account to a merchant account. " . $article->id . $langText,
                ],

            ];
        } elseif ($article->slug == "customer_satisfy_content") {
            $data = [
                "article_id"    => $article->id,
                "language_id"   => $languageId,
                "slug"          => "satisfy_customer_message",
                "small_content" => null,
                "large_content" => "Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments. " . $article->id . $langText,
            ];
        } elseif ($article->slug == "faq_content") {
            $data = [
                "article_id"    => $article->id,
                "language_id"   => $languageId,
                "slug"          => "faq_content_data",
                "small_content" => "When can I deposit/withdraw from my Investment account? " . $article->id . $langText,
                "large_content" => "Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments. " . $article->id . $langText,
            ];
        } elseif ($article->slug == "our_service_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_service_header_head",
                    "small_content" => "Our Services " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_service_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $langText,
                ],
            ];
        } elseif ($article->slug == "our_service") {
            $slug = Str::replace(" ", "_", $article->article_name);
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => $slug . "_header",
                    "small_content" => $article->article_name . " " . $article->id . " " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => $slug . "_content",
                    "small_content" => null,
                    "large_content" => "Specify your shop type and apply to upgrade your standard account to a merchant account. " . $article->id . " " . $langText,
                ],

            ];
        } elseif ($article->slug == "blog") {
            $slug = Str::replace(" ", "_", $article->article_name);
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => $slug . "_header",
                    "small_content" => $article->article_name . " " . $article->id . " " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => $slug . "_details",
                    "small_content" => null,
                    "large_content" => "Specify your shop type and apply to upgrade your standard account to a merchant account. " . $article->id . " " . $langText,
                ],
            ];
        } elseif ($article->slug == "b2x_loan") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_title",
                    "small_content" => "B2X " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_button_one_text",
                    "small_content" => "Get a Loan" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_button_two_text",
                    "small_content" => "Try the loan calculator" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_content",
                    "small_content" => null,
                    "large_content" => "B2X is the simple, seamless way to grow your BTC holdings. This Ledn-exclusive product combines a Ledn Bitcoin-backed Loan with the purchase of an equal amount of Bitcoin. When the loan is repaid, both the collateral and the newly purchased BTC are returned to you." . $langText,
                ],
            ];
        } elseif ($article->slug == "our_difference_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_difference_header_title",
                    "small_content" => "The Our Difference " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_difference_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $langText,
                ],
            ];
        } elseif ($article->slug == "our_rates_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_rates_header_title",
                    "small_content" => "Our Rates " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_rates_header_content",
                    "small_content" => null,
                    "large_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $article->id . $langText,
                ],
            ];
        } elseif ($article->slug == "our_rate_content") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_rate_content_title",
                    "small_content" => "Starting at " . $article->id . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "our_rate_content_body",
                    "small_content" => "Annual Interest Rate " . $article->id . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif (Str::contains($article->slug, '_banner')) {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => $article->slug . "_title",
                    "small_content" => $article->article_name . " " . $article->id . " " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "join_nishue_today") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "join_nishue_today_title",
                    "small_content" => "Join Nishue Today" . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "join_nishue_today_content",
                    "small_content" => "Nishue will match the amount of " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "package_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "package_header_title",
                    "small_content" => "Investment Plan " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "package_header_content",
                    "small_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "team_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "team_header_title",
                    "small_content" => "Team Member " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "team_header_content",
                    "small_content" => "We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please contact us. " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "payment_we_accept_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "payment_we_accept_header_title",
                    "small_content" => $article->article_name . " " . $article->id . " " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "payment_we_accept_header_content",
                    "small_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "top_investor_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "top_investor_header_title",
                    "small_content" => $article->article_name . " " . $article->id . " " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "top_investor_header_content",
                    "small_content" => "To make a solid investment, you have to know where you are investing. Find a plan which is best for you. " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "b2x_calculator_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_calculator_header_title",
                    "small_content" => "B2X calculator " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_calculator_header_content",
                    "small_content" => "Nishue will match the amount of bitcoin deposited, giving you 2X your current holdings. " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_details_header_title",
                    "small_content" => "Loan Details. " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_button_text",
                    "small_content" => "Get a loan. " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "b2x_loan_details_header") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_details_header_title",
                    "small_content" => "Loan Details " . $langText,
                    "large_content" => null,
                ],
            ];
        } elseif ($article->slug == "b2x_loan_details_content") {
            $data = [
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_details_content",
                    "small_content" => "Loan Amount " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_details_content",
                    "small_content" => "Payment Amount (Monthly) " . $langText,
                    "large_content" => null,
                ],

                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_details_content",
                    "small_content" => "Loan Interest Rate " . $langText,
                    "large_content" => null,
                ],
                [
                    "article_id"    => $article->id,
                    "language_id"   => $languageId,
                    "slug"          => "b2x_loan_details_content",
                    "small_content" => "Loan Total " . $langText,
                    "large_content" => null,
                ],
            ];
        }

        return $data;
    }

}
