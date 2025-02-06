<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Models\TeamMemberSocial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        TeamMember::truncate();
        TeamMemberSocial::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        TeamMember::insert([
            [
                "name"        => "Jasika Fernando",
                "designation" => "avatar1.png",
                "avatar"      => "Director",
            ],
            [
                "name"        => "Shek Rekardo Done",
                "designation" => "avatar2.png",
                "avatar"      => "CEO",
            ],
            [
                "name"        => "Albert Smith",
                "designation" => "avatar3.png",
                "avatar"      => "Director",
            ],
            [
                "name"        => "Stepen Jeriad",
                "designation" => "avatar4.png",
                "avatar"      => "Director",
            ],
        ]);

        TeamMemberSocial::insert([
            [
                "team_member_id" => 1,
                "name"           => "Facebook",
                "icon"           => '<i class="fa fa-facebook-official" aria-hidden="true"></i>',
                "url"            => "facebook.com",
            ],
            [
                "team_member_id" => 1,
                "name"           => "Linkdin",
                "icon"           => '<i class="fa fa-linkdin-official" aria-hidden="true"></i>',
                "url"            => "linkdin.com",
            ],
            [
                "team_member_id" => 2,
                "name"           => "Youtube",
                "icon"           => '<i class="fa fa-youtube-official" aria-hidden="true"></i>',
                "url"            => "youtube.com",
            ],
            [
                "team_member_id" => 2,
                "name"           => "Facebook",
                "icon"           => '<i class="fa fa-facebook-official" aria-hidden="true"></i>',
                "url"            => "facebook.com",
            ],
            [
                "team_member_id" => 2,
                "name"           => "Linkdin",
                "icon"           => '<i class="fa fa-linkdin-official" aria-hidden="true"></i>',
                "url"            => "linkdin.com",
            ],
            [
                "team_member_id" => 2,
                "name"           => "Youtube",
                "icon"           => '<i class="fa fa-youtube-official" aria-hidden="true"></i>',
                "url"            => "youtube.com",
            ],
            [
                "team_member_id" => 3,
                "name"           => "Facebook",
                "icon"           => '<i class="fa fa-facebook-official" aria-hidden="true"></i>',
                "url"            => "facebook.com",
            ],
            [
                "team_member_id" => 3,
                "name"           => "Linkdin",
                "icon"           => '<i class="fa fa-linkdin-official" aria-hidden="true"></i>',
                "url"            => "linkdin.com",
            ],
            [
                "team_member_id" => 3,
                "name"           => "Youtube",
                "icon"           => '<i class="fa fa-youtube-official" aria-hidden="true"></i>',
                "url"            => "youtube.com",
            ],
            [
                "team_member_id" => 4,
                "name"           => "Facebook",
                "icon"           => '<i class="fa fa-facebook-official" aria-hidden="true"></i>',
                "url"            => "facebook.com",
            ],
            [
                "team_member_id" => 4,
                "name"           => "Linkdin",
                "icon"           => '<i class="fa fa-linkdin-official" aria-hidden="true"></i>',
                "url"            => "linkdin.com",
            ],
            [
                "team_member_id" => 4,
                "name"           => "Youtube",
                "icon"           => '<i class="fa fa-youtube-official" aria-hidden="true"></i>',
                "url"            => "youtube.com",
            ],
        ]);

    }
}
