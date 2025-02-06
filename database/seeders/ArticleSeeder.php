<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        Article::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Article::insert([
            [
                "slug"         => "header_menu",
                "article_name" => "Header Menu",
            ],
            [
                "slug"         => "footer_menu",
                "article_name" => "Footer Menu",
            ],
            [
                "slug"         => "home_slider",
                "article_name" => "Slider One",
            ],
            [
                "slug"         => "home_slider",
                "article_name" => "Slider Two",
            ],
            [
                "slug"         => "home_about",
                "article_name" => "Home About",
            ],
            [
                "slug"         => "merchant_title",
                "article_name" => "Merchant Title",
            ],
            [
                "slug"         => "merchant_content",
                "article_name" => "Merchant Account",
            ],
            [
                "slug"         => "merchant_content",
                "article_name" => "Payment Link",
            ],
            [
                "slug"         => "merchant_content",
                "article_name" => "Payment Verified",
            ],
            [
                "slug"         => "merchant_content",
                "article_name" => "Fund Withdraw",
            ],
            [
                "slug"         => "merchant_content",
                "article_name" => "Enjoy Our Platform",
            ],
            [
                "slug"         => "investment_header",
                "article_name" => "Investment Header",
            ],
            [
                "slug"         => "why_choose_header",
                "article_name" => "Why Choose Header",
            ],
            [
                "slug"         => "satisfied_customer_header",
                "article_name" => "Satisfied Customer Header",
            ],
            [
                "slug"         => "payment_we_accept_header",
                "article_name" => "Payment We Accept",
            ],
            [
                "slug"         => "faq_header",
                "article_name" => "Faq Header",
            ],
            [
                "slug"         => "top_invest_ranking_header",
                "article_name" => "Top Invest Ranking Header",
            ],
            [
                "slug"         => "why_choose_content",
                "article_name" => "Merchant Account",
            ],
            [
                "slug"         => "why_choose_content",
                "article_name" => "Security Protected",
            ],
            [
                "slug"         => "why_choose_content",
                "article_name" => "Support 24/7",
            ],
            [
                "slug"         => "why_choose_content",
                "article_name" => "Registered Company",
            ],
            [
                "slug"         => "why_choose_content",
                "article_name" => "Live Exchange Rates",
            ],
            [
                "slug"         => "why_choose_content",
                "article_name" => "Legal Company",
            ],
            [
                "slug"         => "customer_satisfy_content",
                "article_name" => "Gediminus Griska",
            ],
            [
                "slug"         => "customer_satisfy_content",
                "article_name" => "Vidas Rustkauskas",
            ],
            [
                "slug"         => "customer_satisfy_content",
                "article_name" => "Andriy Naumov",
            ],
            [
                "slug"         => "faq_content",
                "article_name" => "Frequently Asked Questions",
            ],
            [
                "slug"         => "faq_content",
                "article_name" => "Frequently Asked Questions",
            ],
            [
                "slug"         => "faq_content",
                "article_name" => "Frequently Asked Questions",
            ],
            [
                "slug"         => "faq_content",
                "article_name" => "Frequently Asked Questions",
            ],
            [
                "slug"         => "our_service_header",
                "article_name" => "Our Service Header",
            ],
            [
                "slug"         => "our_service",
                "article_name" => "Stake",
            ],
            [
                "slug"         => "our_service",
                "article_name" => "Mechant",
            ],
            [
                "slug"         => "our_service",
                "article_name" => "B2X Loan",
            ],
            [
                "slug"         => "blog",
                "article_name" => "Blog",
            ],
            [
                "slug"         => "blog",
                "article_name" => "Blog-two",
            ],
            [
                "slug"         => "blog",
                "article_name" => "Blog-three",
            ],
            [
                "slug"         => "social_icon",
                "article_name" => "Facebook",
            ],
            [
                "slug"         => "social_icon",
                "article_name" => "Instagram",
            ],
            [
                "slug"         => "social_icon",
                "article_name" => "Linkedin",
            ],
            [
                "slug"         => "b2x_loan",
                "article_name" => "B2X Loan",
            ],
            [
                "slug"         => "our_difference_header",
                "article_name" => "The Our Difference",
            ],
            [
                "slug"         => "our_difference_content",
                "article_name" => "Easy && Accessible",
            ],
            [
                "slug"         => "our_difference_content",
                "article_name" => "Instant Execution",
            ],
            [
                "slug"         => "our_difference_content",
                "article_name" => "Instant Flexible",
            ],
            [
                "slug"         => "our_rates_header",
                "article_name" => "Our Rates",
            ],
            [
                "slug"         => "our_rate_content",
                "article_name" => "50%",
            ],
            [
                "slug"         => "our_rate_content",
                "article_name" => "Starting at 10.4%",
            ],
            [
                "slug"         => "our_rate_content",
                "article_name" => "Starting at 10.4%",
            ],
            [
                "slug"         => "join_nishue_today",
                "article_name" => "Join With nishue",
            ],
            [
                "slug"         => "package_banner",
                "article_name" => "Package Banner",
            ],
            [
                "slug"         => "package_header",
                "article_name" => "Investment Plan",
            ],
            [
                "slug"         => "top_investor_banner",
                "article_name" => "Top Investor Banner",
            ],
            [
                "slug"         => "merchant_top_banner",
                "article_name" => "Merchant Banner",
            ],
            [
                "slug"         => "blog_top_banner",
                "article_name" => "Blog",
            ],
            [
                "slug"         => "blog_details_top_banner",
                "article_name" => "Blog Details",
            ],
            [
                "slug"         => "contact_us_top_banner",
                "article_name" => "Contact Us",
            ],
            [
                "slug"         => "team_member_banner",
                "article_name" => "Team Member",
            ],
            [
                "slug"         => "about_us_banner",
                "article_name" => "About Us",
            ],
            [
                "slug"         => "service_top_banner",
                "article_name" => "Services",
            ],
            [
                "slug"         => "top_investor_top_banner",
                "article_name" => "Top Investor Rank",
            ],
            [
                "slug"         => "quick_exchange_top_banner",
                "article_name" => "Quick Exchange",
            ],
            [
                "slug"         => "stake_banner",
                "article_name" => "Stake Pricing",
            ],
            [
                "slug"         => "b2x_loan_banner",
                "article_name" => "B2x Loan Banner",
            ],
            [
                "slug"         => "team_header",
                "article_name" => "Team Header",
            ],
            [
                "slug"         => "top_investor_header",
                "article_name" => "Our Top Investors",
            ],
            [
                "slug"         => "b2x_calculator_header",
                "article_name" => "B2x Calculator",
            ],
            [
                "slug"         => "b2x_loan_details_header",
                "article_name" => "B2x Loan Details",
            ],
            [
                "slug"         => "b2x_loan_details_content",
                "article_name" => "B2x Loan Details Content",
            ],
        ]);
    }
}
