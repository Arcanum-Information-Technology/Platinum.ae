<?php

namespace App\Services;

class ShakespeareSections
{
    public static function definitions(): array
    {
        return [
            'sh_hero' => [
                'name' => 'Hero Video',
                'description' => 'Full-width video with a centered title, used on the home page',
                'icon' => 'video',
                'fields' => [
                    ['key' => 'title', 'label' => 'Overlay title', 'type' => 'text'],
                    ['key' => 'video', 'label' => 'Background video', 'type' => 'media'],
                    ['key' => 'poster', 'label' => 'Poster image (shown before the video plays)', 'type' => 'media'],
                ],
                'defaults' => [
                    'title' => 'SUMMER MENU',
                    'video' => 'home-page/08131.mp4',
                    'poster' => 'home-page/Untitled-1-2048x1017.jpg',
                ],
            ],
            'sh_story' => [
                'name' => 'Our Story',
                'description' => 'Ornament, story copy, food photos, and a side image with text',
                'icon' => 'book-open',
                'fields' => [
                    ['key' => 'ornament', 'label' => 'Ornament image', 'type' => 'media'],
                    ['key' => 'body', 'label' => 'Story paragraphs (separate paragraphs with a blank line)', 'type' => 'textarea'],
                    ['key' => 'image_one', 'label' => 'Left photo', 'type' => 'media'],
                    ['key' => 'image_two', 'label' => 'Right photo', 'type' => 'media'],
                    ['key' => 'side_image', 'label' => 'Wide photo', 'type' => 'media'],
                    ['key' => 'side_text', 'label' => 'Text beside the wide photo', 'type' => 'textarea'],
                ],
                'defaults' => [
                    'ornament' => 'home-page/Our-Story-1-1-2048x724.png',
                    'body' => <<<'TXT'
In 2001, Aline Abtour brought a touch of fairytale charm to Dubai with Shakespeare & Co. It is a café where vintage furniture is the new trend, chandeliers glowed warmly, and every classic dish and freshly baked pastries told a story. For over two decades, it became the city’s beloved retreat, a place for first dates and friendships that lasted lifetimes.

When the original chapter closed in 2023, it felt like the end of an era.

But legends don’t fade, they evolve.

Now, under Platinum Hospitality Management, spearheaded by CEO Ahmad Atwi, Shakespeare Middle East Café & Restaurant is rekindling that magic. The soul remains the same – thoughtful food, clink of cutlery and quiet laughter, and that unmistakable warmth, but with a fresh vision for the future.

This isn’t just a homecoming. It’s a new beginning.
TXT,
                    'image_one' => 'home-page/home1.jpg',
                    'image_two' => 'home-page/home2.jpg',
                    'side_image' => 'home-page/Untitled-1-2048x1017.jpg',
                    'side_text' => 'Shakespeare Middle East reimagines the legacy of its classic predecessor, offering a refined retreat where literature and leisure intertwine. Located in the vibrant Bawabat Al Sharq, it’s a haven for those who appreciate the aroma of freshly brewed coffee, inspired cuisine, and delectable French pastries. The ambiance is a blend of old-world charm and contemporary comfort, invites guests to linger over meals, conversations. Here, every visit feels like stepping into a story where culture, taste, and timeless elegance converge.',
                ],
            ],
            'sh_expertise' => [
                'name' => 'Our Expertise',
                'description' => 'Four highlight cards on the cream background',
                'icon' => 'layout-grid',
                'fields' => [
                    ['key' => 'ornament', 'label' => 'Ornament image', 'type' => 'media'],
                    [
                        'key' => 'items',
                        'label' => 'Cards',
                        'type' => 'repeater',
                        'fields' => [
                            ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                            ['key' => 'body', 'label' => 'Text', 'type' => 'textarea'],
                            ['key' => 'icon', 'label' => 'Icon', 'type' => 'media'],
                        ],
                    ],
                ],
                'defaults' => [
                    'ornament' => 'home-page/Our-Expertise-1-1-2048x721.png',
                    'items' => [
                        [
                            'title' => 'International Food',
                            'icon' => 'home-page/icon/output-onlinepngtools-2.png',
                            'body' => 'Experience a grand culinary adventure in the heart of the UAE. We unite classic comforts and modern favorites on one exciting menu. Savor everything from a lavish American breakfast and gourmet burgers to succulent lamb shank and delicate French pastries, ending with the aromatic ritual of Moroccan tea. This celebration of world flavors framed in historic charm.',
                        ],
                        [
                            'title' => 'Relaxing Shisha Lounge',
                            'icon' => 'home-page/icon/output-onlinepngtools-3.png',
                            'body' => 'Discover the height of lounge luxury with our premium shisha service. Set within elegant Victorian decor, we elevate the timeless tradition with an extensive menu of exceptional flavors. Choose from classic favorites to inventive house-specialty blends, each prepared with precision for perfect purity and lasting flavor. Designed for the discerning guest, it’s the definitive way to unwind, a seamless blend of heritage, comfort, and vibrant social atmosphere.',
                        ],
                        [
                            'title' => 'Great Location & Ambiance',
                            'icon' => 'home-page/icon/output-onlinepngtools-4.png',
                            'body' => 'Step into a Victorian-era sanctuary in the heart of the mall. Our flagship restaurant at Bawabat Al Sharq Mall offers a complete experience of dine-in elegance and vibrant terrace dining. Your neighborhood gourmet stop, right where you live and work. Nestled within the vibrant Radiant Square residential and office tower at Podium 7, our express branch brings exceptional, chef-crafted flavours to your doorstep. Perfect for a quick lunch between meetings, a takeaway dinner after a long day, or a casual meal by the community pool. Quality dining, seamlessly integrated into your urban lifestyle.',
                        ],
                        [
                            'title' => 'Friendly Hospitality',
                            'icon' => 'home-page/icon/output-onlinepngtools-5.png',
                            'body' => 'We believe the finest ingredient in any restaurant is a heartfelt welcome. Our team provides hospitality that is both attentive and refreshingly genuine. Expect warm smiles, knowledgeable recommendations, and service that anticipates your needs without intrusion. Whether you’re here for a leisurely three-course meal, a quick business lunch, or a relaxing shisha evening, we are dedicated to making your experience seamless and personally memorable. Your comfort is our priority.',
                        ],
                    ],
                ],
            ],
            'sh_reviews' => [
                'name' => 'Guest Reviews',
                'description' => 'Review cards. The quotes themselves are managed under Testimonials.',
                'icon' => 'message-square',
                'fields' => [
                    ['key' => 'ornament', 'label' => 'Ornament image', 'type' => 'media'],
                ],
                'defaults' => [
                    'ornament' => 'home-page/hear-from-customers-2-1-2048x716.png',
                ],
            ],
            'sh_cta_bar' => [
                'name' => 'Location Banner',
                'description' => 'Wide photo, shown twice, with two buttons over it',
                'icon' => 'rectangle-horizontal',
                'fields' => [
                    ['key' => 'image', 'label' => 'Background photo (shown twice)', 'type' => 'media'],
                    ['key' => 'primary_text', 'label' => 'Left button label', 'type' => 'text'],
                    ['key' => 'primary_url', 'label' => 'Left button link', 'type' => 'text'],
                    ['key' => 'secondary_text', 'label' => 'Right button label', 'type' => 'text'],
                    ['key' => 'secondary_url', 'label' => 'Right button link', 'type' => 'text'],
                ],
                'defaults' => [
                    'image' => 'home-page/SAC_Dubai_Marina_Mall_New_898x608_crop_center.webp',
                    'primary_text' => 'Make a Reservation',
                    'primary_url' => '/contact',
                    'secondary_text' => 'Explore Our Locations',
                    'secondary_url' => '/our-branches',
                ],
            ],
            'sh_banner' => [
                'name' => 'Page Title Banner',
                'description' => 'Grey title band, used on About and similar pages',
                'icon' => 'heading',
                'fields' => [
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                ],
                'defaults' => [
                    'title' => 'About Us',
                ],
            ],
            'sh_prose' => [
                'name' => 'Centered Text',
                'description' => 'Optional ornament plus centered paragraphs',
                'icon' => 'align-center',
                'fields' => [
                    ['key' => 'ornament', 'label' => 'Ornament image (optional)', 'type' => 'media'],
                    ['key' => 'body', 'label' => 'Paragraphs (separate paragraphs with a blank line)', 'type' => 'textarea'],
                ],
                'defaults' => [
                    'ornament' => '',
                    'body' => '',
                ],
            ],
            'sh_photo' => [
                'name' => 'Full Photo',
                'description' => 'A single wide photograph',
                'icon' => 'image',
                'fields' => [
                    ['key' => 'image', 'label' => 'Photo', 'type' => 'media'],
                    ['key' => 'alt', 'label' => 'Description', 'type' => 'text'],
                ],
                'defaults' => [
                    'image' => 'home-page/Untitled-1-2048x1017.jpg',
                    'alt' => 'Shakespeare Middle East dining room',
                ],
            ],
            'sh_values' => [
                'name' => 'Core Values',
                'description' => 'Four text columns under an ornament',
                'icon' => 'columns-4',
                'fields' => [
                    ['key' => 'ornament', 'label' => 'Ornament image', 'type' => 'media'],
                    [
                        'key' => 'items',
                        'label' => 'Columns',
                        'type' => 'repeater',
                        'fields' => [
                            ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                            ['key' => 'body', 'label' => 'Text', 'type' => 'textarea'],
                        ],
                    ],
                ],
                'defaults' => [
                    'ornament' => 'images/about/core-values-2-1-1024x354.png',
                    'items' => [
                        [
                            'title' => 'Our Core Values',
                            'body' => 'We stay true to the rich culinary traditions of the world. Our chefs use classic recipes, fresh ingredients, and traditional cooking techniques to bring you flavors that feel just like home.',
                        ],
                        [
                            'title' => 'Quality',
                            'body' => 'Quality is our main ingredient. It’s in our from-scratch kitchen, our attentive service and the care we take in creating a memorable dining experience for every guest.',
                        ],
                        [
                            'title' => 'Hospitality',
                            'body' => 'At Shakespeare, you’re not just a customer, you’re our guest. Our team is dedicated to providing friendly service, a warm atmosphere, and a dining experience that makes you feel welcome.',
                        ],
                        [
                            'title' => 'Community',
                            'body' => 'Food is meant to bring people together. Whether it’s a family meal, a gathering with friends, or a quiet moment with a cup of coffee, Shakespeare is a place where connections are made and memories are shared.',
                        ],
                    ],
                ],
            ],
            'sh_form' => [
                'name' => 'Enquiry Form',
                'description' => 'Contact or franchise enquiry form. Submissions are saved under Messages.',
                'icon' => 'mail',
                'fields' => [
                    ['key' => 'title', 'label' => 'Heading', 'type' => 'text'],
                    ['key' => 'submit_label', 'label' => 'Button label', 'type' => 'text'],
                    ['key' => 'show_territory', 'label' => 'Show territory field (1 = yes, 0 = no)', 'type' => 'text'],
                    ['key' => 'subject', 'label' => 'Subject saved with the message', 'type' => 'text'],
                ],
                'defaults' => [
                    'title' => "Let's connect!",
                    'submit_label' => 'Enquire Now',
                    'show_territory' => '1',
                    'subject' => 'Franchise enquiry',
                ],
            ],
            'sh_branch' => [
                'name' => 'Branches',
                'description' => 'Map and contact details for each branch',
                'icon' => 'map-pin',
                'fields' => [
                    ['key' => 'ornament', 'label' => 'Ornament image', 'type' => 'media'],
                    [
                        'key' => 'branches',
                        'label' => 'Branches',
                        'type' => 'repeater',
                        'fields' => [
                            ['key' => 'name', 'label' => 'Branch name', 'type' => 'text'],
                            ['key' => 'address', 'label' => 'Address', 'type' => 'text'],
                            ['key' => 'phone', 'label' => 'Phone', 'type' => 'text'],
                            ['key' => 'whatsapp', 'label' => 'WhatsApp', 'type' => 'text'],
                            ['key' => 'hours', 'label' => 'Working hours', 'type' => 'text'],
                            ['key' => 'map_query', 'label' => 'Map search (place name)', 'type' => 'text'],
                            ['key' => 'menu_label', 'label' => 'Menu button label', 'type' => 'text'],
                            ['key' => 'menu_url', 'label' => 'Menu button link', 'type' => 'text'],
                            ['key' => 'chat_label', 'label' => 'Chat button label', 'type' => 'text'],
                        ],
                    ],
                ],
                'defaults' => [
                    'ornament' => 'Our Branches/our-branches-2-1-2048x722.png',
                    'branches' => [
                        [
                            'name' => 'Baniyas, Abu Dhabi, UAE',
                            'address' => 'Shakespeare | Bawabat Al Sharq Mall | Abu Dhabi – UAE',
                            'phone' => '+971 2 4490407',
                            'whatsapp' => '+971 568763616',
                            'hours' => '9:00AM-11:30PM',
                            'map_query' => 'Shakespeare Bawabat Al Sharq Mall, Baniyas, Abu Dhabi',
                            'menu_label' => 'Get Menu',
                            'menu_url' => '/menu',
                            'chat_label' => 'Chat with us',
                        ],
                    ],
                ],
            ],
        ];
    }
}
