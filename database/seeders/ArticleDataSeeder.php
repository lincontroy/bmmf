<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ArticleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        ArticleData::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $articles = Article::all();

        foreach ($articles as $article) {
            $createData = $this->getCreateData($article);
            ArticleData::create($createData);
        }

    }

    private function getCreateData($article): array
    {
        $data = [];

        if ($article->slug == "home_slider") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'slider' . $article->id . '.png',
                ],
                [
                    "article_id" => $article->id,
                    "slug"       => 'url',
                    "content"    => url('/' . $article->id),
                ],
            ];
        } elseif ($article->slug == "home_about") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'about' . $article->id . '.png',
                ],
                [
                    "article_id" => $article->id,
                    "slug"       => 'url',
                    "content"    => url('/' . $article->id),
                ],
            ];
        } elseif ($article->slug == "merchant_content") {
            $data = [
                "article_id" => $article->id,
                "slug"       => 'image',
                "content"    => 'merchant_' . $article->id . '.png',
            ];
        } elseif ($article->slug == "why_choose_content") {
            $data = [
                "article_id" => $article->id,
                "slug"       => 'image',
                "content"    => 'choose_content' . $article->id . '.png',
            ];
        } elseif ($article->slug == "customer_satisfy_content") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'customer_satisfy' . $article->id . '.png',
                ],
                [
                    "article_id" => $article->id,
                    "slug"       => 'name',
                    "content"    => 'Customer Name ' . $article->id,
                ],
                [
                    "article_id" => $article->id,
                    "slug"       => 'company_name',
                    "content"    => 'Company Name ' . $article->id,
                ],
                [
                    "article_id" => $article->id,
                    "slug"       => 'url',
                    "content"    => url('/' . $article->id),
                ],
            ];
        } elseif ($article->slug == "our_service") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'service' . $article->id . '.png',
                ],
            ];
        } elseif ($article->slug == "blog") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'blog' . $article->id . '.png',
                ],
            ];
        } elseif ($article->slug == "social_icon") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'url',
                    "content"    => $article->article_name,
                ],
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'social_icon' . $article->id . '.png',
                ],
            ];
        } elseif ($article->slug == "b2x_loan") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'b2x_loan' . $article->id . '.png',
                ],
            ];
        } elseif ($article->slug == "our_difference_content") {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => 'difference_content' . $article->id . '.png',
                ],
            ];
        } elseif (Str::contains($article->slug, '_banner')) {
            $data = [
                [
                    "article_id" => $article->id,
                    "slug"       => 'image',
                    "content"    => $article->slug . $article->id . '.png',
                ],
            ];
        }

        return $data;
    }

}
