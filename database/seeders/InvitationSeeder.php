<?php

namespace Database\Seeders;

use App\Models\Invitation;
use App\Models\Story;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Invitation
        $invitation = Invitation::create([
            'theme_id' => 1, // Theme
            'music_id' => 1, // Music
            'prefix_route' => 'weddingcontoh',
            'code' => substr(bin2hex(random_bytes(8)), 0, 8),
            'password' => Hash::make('12345678'),
            'password_default' => '12345678',
            'customer_name' => 'Kacoon',
            'phone' => '+6285735692773',
            'email' => 'kacoon@mail.com',
            'is_sample' => true,
            'is_active' => true,
            'is_published' => true
        ]);
        // Wedding Data
        $invitation->wedding_data()->create([
            // Groom
            'groom_name' => 'Romeo',
            'groom_birthplace' => 'Gresik',
            'groom_birthday' => '1999-09-25',
            'groom_father' => 'Steve Rogers',
            'groom_mother' => 'Gamora',
            // Bride
            'bride_name' => 'Juliet',
            'bride_birthplace' => 'Surabaya',
            'bride_birthday' => '1999-07-15',
            'bride_father' => 'Tony Stark',
            'bride_mother' => 'Wanda',
            // Quotes
            'quotes' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan
            pasangan-pasangan untukmu dari jenismu sendiri, agar kamu
            cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di
            antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu
            benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum
            yang berpikir.',
            'quotes_by' => 'QS. Ar-Rum Ayat 21',
            // Youtube
            'youtube_video' => 'https://www.youtube.com/embed/ojodJ2BEmZk',
            // Akad
            'akad_date' => '2024-07-20',
            'akad_start' => '08:00',
            'akad_end' => '10:00',
            'akad_place' => 'Masjid Agung Surabaya',
            'akad_maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.153841927027!2d112.71260567422716!3d-7.336614092671883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fba9cfb6dfab%3A0x6fe7210ef241206!2sMasjid%20Nasional%20Al-Akbar%20Surabaya!5e0!3m2!1sid!2sid!4v1713257952949!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            // Resepsi
            'reception_date' => '2024-07-20',
            'reception_start' => '14:00',
            'reception_end' => '18:00',
            'reception_place' => 'PTC Convention Hall, Jl Raya Lontar No 99 Surabaya',
            'reception_maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.574626985207!2d112.67314837422656!3d-7.2891413927182676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fc364741c0c3%3A0xba3176bca0f4205a!2sPakuwon%20Mall%20Surabaya!5e0!3m2!1sid!2sid!4v1713258031518!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            // Gift Address
            'gift_address' => 'Jl. Raya Pasar Menganti No 199, Gresik',
        ]);

        // Delete all invitations files
        Storage::deleteDirectory('invitations');

        // Seed couple
        $couple_photos = Storage::disk('root')->allFiles('/storage/seeders/weddingcouple');
        foreach ($couple_photos as $key => $source) {
            $target1 = str_replace('storage/seeders/weddingcouple', "storage/app/public/invitations/$invitation->id", $source);
            $target2 = str_replace('storage/seeders/weddingcouple', "storage/invitations/$invitation->id", $source);
            Storage::disk('root')->copy($source, $target1);
        }
        $invitation->wedding_data()->update([
            'groom_photo' => "storage/invitations/$invitation->id/groom.jpg",
            'bride_photo' => "storage/invitations/$invitation->id/bride.jpg"
        ]);

        // Seed gallery & story
        $gallery_photos = Storage::disk('root')->allFiles('/storage/seeders/weddinggallery');
        foreach ($gallery_photos as $key => $source) {
            $target1 = str_replace('storage/seeders/weddinggallery', "storage/app/public/invitations/$invitation->id", $source);
            $target2 = str_replace('storage/seeders/weddinggallery', "storage/invitations/$invitation->id", $source);
            Storage::disk('root')->copy($source, $target1);
            $invitation->wedding_data->galleries()->create([
                'path' => $target2,
                'sort' => ($key + 1)
            ]);
            $invitation->wedding_data->stories()->create([
                'picture_path' => $target2,
                'story_date' => fake()->date(),
                'title' => fake()->sentence(2),
                'description' => fake()->sentence(20)
            ]);
        }

        // Seed gifts
        for ($i = 1; $i <= 3; $i++) {
            $invitation->wedding_data->gift_channels()->create([
                'bank_channel_id' => $i,
                'number' => fake()->creditCardNumber(),
                'name' => 'Romeo'
            ]);
        }
    }
}
