<?php

namespace App\Services;

class PlatinumSections
{
    public static function definitions(): array
    {
        return [
            'plat_hero' => [
                'name' => 'Platinum Hero Banner',
                'description' => 'Luxury full-width hero with champagne gold typography and dual CTAs',
                'icon' => 'sparkles',
                'defaults' => [
                    'badge' => 'Culinary Excellence Across The UAE',
                    'title' => 'Platinum Hospitality Management',
                    'subtitle' => 'Your strategic partner in culinary excellence, delivering world-class hospitality solutions through quality, efficiency, and sustainable growth.',
                    'cta_text' => 'Discover Our Brands',
                    'cta_link' => '#our-brands',
                    'cta2_text' => 'Book Table Online',
                    'cta2_link' => '#book-table',
                    'hero_image' => 'images/platinum/hero/platinum-hero.jpg',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Gold Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Hero Heading', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Hero Subtitle', 'type' => 'textarea'],
                    ['key' => 'cta_text', 'label' => 'Primary Button Text', 'type' => 'text'],
                    ['key' => 'cta_link', 'label' => 'Primary Button Link', 'type' => 'text'],
                    ['key' => 'cta2_text', 'label' => 'Secondary Button Text', 'type' => 'text'],
                    ['key' => 'cta2_link', 'label' => 'Secondary Button Link', 'type' => 'text'],
                    ['key' => 'hero_image', 'label' => 'Hero Background Image', 'type' => 'media'],
                ],
            ],
            'plat_brands' => [
                'name' => 'Signature Portfolio Brands',
                'description' => 'Showcase of Shakespeare Middle East, Otantik, and Chinese Connection',
                'icon' => 'grid',
                'defaults' => [
                    'badge' => 'Signature Portfolio',
                    'title' => 'OUR BRANDS',
                    'subtitle' => 'Discover our restaurant locations across the region, each offering the same signature experience.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Section Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Main Heading', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_about_intro' => [
                'name' => 'Company Story & CEO Narrative',
                'description' => 'Brand story split block with artisan panini photography and partnership inquiry highlight',
                'icon' => 'book-open',
                'defaults' => [
                    'badge' => 'Company Overview',
                    'title' => 'Platinum Hospitality Management',
                    'description' => 'Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts. As a trusted partner in the hospitality industry, we specialize in delivering refined culinary experiences supported by strong operational expertise and sustainable growth strategies.',
                    'ceo_title' => 'CEO & Founder PLATINUM HOSPITALITY',
                    'image' => 'images/platinum/dishes/vegetarian-sandwich-panini-with-spinach-leaves-tomatoes-and-cheese.jpg',
                    'cta_text' => 'Connect With Us Anytime',
                    'cta_link' => '/contact',
                    'inquiry_heading' => 'Business & Partnership Inquiries',
                    'inquiry_text' => 'Reach out to Platinum Hospitality Management for brand partnerships, restaurant management solutions, and hospitality collaborations.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Section Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Heading', 'type' => 'text'],
                    ['key' => 'description', 'label' => 'Corporate Description', 'type' => 'textarea'],
                    ['key' => 'ceo_title', 'label' => 'CEO Title Tagline', 'type' => 'text'],
                    ['key' => 'image', 'label' => 'Dish Photography', 'type' => 'media'],
                    ['key' => 'inquiry_heading', 'label' => 'Inquiry Box Title', 'type' => 'text'],
                    ['key' => 'inquiry_text', 'label' => 'Inquiry Box Description', 'type' => 'textarea'],
                    ['key' => 'cta_text', 'label' => 'CTA Button Text', 'type' => 'text'],
                    ['key' => 'cta_link', 'label' => 'CTA Button Link', 'type' => 'text'],
                ],
            ],
            'plat_why_choose_us' => [
                'name' => 'Why Platinum Hospitality (4 Pillars)',
                'description' => 'Operational Excellence, Brand-Centric Approach, Proven Industry Expertise, Scalable Growth',
                'icon' => 'award',
                'defaults' => [
                    'badge' => 'The Platinum Standard',
                    'title' => 'Why Platinum Hospitality Management',
                    'subtitle' => 'A trusted partner delivering excellence across every aspect of hospitality management.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Gold Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Section Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_philosophy' => [
                'name' => 'Core Philosophy & Quote',
                'description' => 'Editorial quote banner on deep slate with gold accents',
                'icon' => 'quote',
                'defaults' => [
                    'badge' => 'Our Core Philosophy',
                    'title' => 'Where Hospitality Goes Beyond Food',
                    'subtitle' => 'We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.',
                    'quote' => 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.',
                    'author' => 'Platinum Hospitality Management Leadership',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Section Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Heading', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Philosophy Statement', 'type' => 'textarea'],
                    ['key' => 'quote', 'label' => 'Leadership Quote', 'type' => 'textarea'],
                    ['key' => 'author', 'label' => 'Quote Attribution', 'type' => 'text'],
                ],
            ],
            'plat_hours_booking' => [
                'name' => 'Opening Hours & Table Booking Form',
                'description' => 'Weekly operational hours schedule and interactive table reservation form',
                'icon' => 'clock',
                'defaults' => [
                    'badge' => 'Hospitality Hours & Reservations',
                    'title' => 'Booking Table In Online',
                    'subtitle' => 'Reserve your table across any of our signature venues in Dubai and Abu Dhabi.',
                    'phone' => '+971 4 360 8888',
                    'email' => 'info@platinumhospitality.ae',
                    'location' => 'United Arab Emirates',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                    ['key' => 'phone', 'label' => 'Concierge Phone', 'type' => 'text'],
                    ['key' => 'email', 'label' => 'Concierge Email', 'type' => 'text'],
                    ['key' => 'location', 'label' => 'Office Region', 'type' => 'text'],
                ],
            ],
            'plat_testimonials' => [
                'name' => 'Guest & Client Reviews Carousel',
                'description' => 'Sophie Laurent, Eveline Gagneux, Ahmed Al Mansoori testimonials',
                'icon' => 'message-square',
                'defaults' => [
                    'badge' => 'Guest & Partner Trust',
                    'title' => 'Our Clients Say',
                    'subtitle' => 'Testimonials from discerning diners, investors, and long-term hospitality partners.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Section Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_partner_cta' => [
                'name' => 'Partner With Platinum CTA & Newsletter',
                'description' => 'Investor partnership banner, corporate statement, and email newsletter subscription',
                'icon' => 'handshake',
                'defaults' => [
                    'badge' => 'Strategic Collaboration',
                    'title' => 'Partner With Platinum Hospitality Management',
                    'subtitle' => 'Building Strong Hospitality Brands Together',
                    'description' => 'Platinum Hospitality Management collaborates with investors, property owners, and hospitality entrepreneurs to develop, manage, and scale successful food and beverage concepts with long-term value.',
                    'footer_quote' => 'Driving Growth Through Strategic Hospitality Management. Built on experience. Driven by performance.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text'],
                    ['key' => 'description', 'label' => 'Partnership Scope', 'type' => 'textarea'],
                    ['key' => 'footer_quote', 'label' => 'Corporate Motto Quote', 'type' => 'textarea'],
                ],
            ],
            'plat_about_hero' => [
                'name' => 'About Us Hero Banner',
                'description' => 'Header banner for about page',
                'icon' => 'info',
                'defaults' => [
                    'badge' => 'Our Identity & Purpose',
                    'title' => 'About Platinum Hospitality Management',
                    'subtitle' => 'A premier UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Page Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_story_ceo' => [
                'name' => 'About Story & CEO Spotlight',
                'description' => 'Expanded narrative on about page',
                'icon' => 'user-check',
                'defaults' => [
                    'title' => 'Platinum Hospitality Management',
                    'description' => 'Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts. As a trusted partner in the hospitality industry, we specialize in delivering refined culinary experiences supported by strong operational expertise and sustainable growth strategies.',
                    'ceo_badge' => 'CEO & Founder PLATINUM HOSPITALITY',
                ],
                'fields' => [
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'description', 'label' => 'Story Description', 'type' => 'textarea'],
                    ['key' => 'ceo_badge', 'label' => 'CEO Title Tag', 'type' => 'text'],
                ],
            ],
            'plat_excellence_metrics' => [
                'name' => 'Excellence Stats & Progress Bars',
                'description' => 'Quality Food (89%), Professional Chef (93%), Trusted Consument (98%)',
                'icon' => 'percent',
                'defaults' => [
                    'badge' => 'Decades of Hospitality Management Excellence',
                    'title' => 'Strategic Expertise. Operational Precision.',
                    'description' => 'With decades of combined industry experience, Platinum Hospitality Management specializes in building, managing, and scaling high-performing food and beverage brands.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                ],
            ],
            'plat_milestones' => [
                'name' => 'Historical Milestones Timeline',
                'description' => 'Interactive timeline: 1989, 1998, 2007, 2017',
                'icon' => 'milestone',
                'defaults' => [
                    'badge' => 'Our Historical Trajectory',
                    'title' => 'Milestones That Define Us',
                    'subtitle' => 'From artisanal beginnings to regional multi-brand hospitality leadership.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Heading', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_branches_showcase' => [
                'name' => 'Our Branches & Locations Grid',
                'description' => 'Showcase of restaurant venues with photos, description, and directions',
                'icon' => 'map-pin',
                'defaults' => [
                    'badge' => 'Multi-Concept Footprint',
                    'title' => 'OUR BRANCHES',
                    'subtitle' => 'Discover our restaurant locations across the region, each offering the same signature experience.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_strategic_pillars' => [
                'name' => 'Strategic Pillars & Capabilities',
                'description' => 'Operational Excellence, Brand Development, Strategic Partnerships, Sustainable Growth',
                'icon' => 'layers',
                'defaults' => [
                    'badge' => 'Strategic Pillars',
                    'title' => 'Building Exceptional Hospitality Brands',
                    'subtitle' => 'Where Hospitality Meets Strategic Excellence',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_founders_team' => [
                'name' => 'Meet Our Founders & Chefs',
                'description' => 'Aroldo De Marco, Quetzalli Antonio, Jovanni Scutari, Edda Rivera',
                'icon' => 'users',
                'defaults' => [
                    'badge' => 'Leadership & Culinary Masters',
                    'title' => 'Meet Our Founders',
                    'subtitle' => 'PLATINUM HOSPITALITY',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_brands_hero' => [
                'name' => 'Brands Page Hero',
                'description' => 'Hero banner for the Brands portfolio page',
                'icon' => 'tag',
                'defaults' => [
                    'badge' => 'Dining Concepts',
                    'title' => 'Our Portfolio Brands',
                    'subtitle' => 'Distinctive gastronomic concepts unified by uncompromising standards of service and culinary innovation.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_franchise_hero' => [
                'name' => 'Franchise Page Hero',
                'description' => 'Hero banner for franchise enquiries',
                'icon' => 'briefcase',
                'defaults' => [
                    'badge' => 'Grow With Platinum Hospitality',
                    'title' => 'Franchise & Partnership Enquiry',
                    'subtitle' => 'Join hands with Platinum Hospitality Management to build and grow successful hospitality brands.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_franchise_form' => [
                'name' => 'Interactive Franchise Application Form',
                'description' => 'Full Name, Mobile, Email, Select Brand dropdown, Message',
                'icon' => 'file-text',
                'defaults' => [
                    'title' => 'Submit Franchise Application',
                    'subtitle' => 'Our franchise development team will review your application and schedule a private discovery call.',
                ],
                'fields' => [
                    ['key' => 'title', 'label' => 'Form Header Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Form Instructions Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_franchise_support' => [
                'name' => 'Franchise Journey & Support Pillars',
                'description' => 'Comprehensive Support and Proven Systems overview',
                'icon' => 'help-circle',
                'defaults' => [
                    'badge' => 'Partnership Ecosystem',
                    'title' => 'Your Franchise Journey Starts Here',
                    'subtitle' => 'Comprehensive Support. Proven Systems.',
                    'description' => 'Platinum Hospitality Management provides end-to-end franchise support — from concept setup and operational training to marketing strategy and long-term business growth.',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text'],
                    ['key' => 'description', 'label' => 'Support Overview', 'type' => 'textarea'],
                ],
            ],
            'plat_contact_hero' => [
                'name' => 'Contact Page Hero',
                'description' => 'Hero banner for contact page',
                'icon' => 'phone',
                'defaults' => [
                    'badge' => 'Connect With Platinum',
                    'title' => 'Get In Touch',
                    'subtitle' => 'Business & Partnership Enquiries',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
            'plat_contact_split' => [
                'name' => 'Contact Split Form & Details',
                'description' => 'Direct contact form, phone, email, UAE address, social links',
                'icon' => 'mail',
                'defaults' => [
                    'description' => 'Connect with Platinum Hospitality Management for franchise opportunities, brand partnerships, and hospitality management solutions.',
                    'location' => 'United Arab Emirates',
                    'phone' => '+971 4 360 8888',
                    'email' => 'info@platinumhospitality.ae',
                ],
                'fields' => [
                    ['key' => 'description', 'label' => 'Intro Text', 'type' => 'textarea'],
                    ['key' => 'location', 'label' => 'Office Location', 'type' => 'text'],
                    ['key' => 'phone', 'label' => 'Phone', 'type' => 'text'],
                    ['key' => 'email', 'label' => 'Email', 'type' => 'text'],
                ],
            ],
            'plat_brand_hero' => [
                'name' => 'Dedicated Brand Sub-Page Hero',
                'description' => 'Hero banner with breadcrumb, brand title, and tagline',
                'icon' => 'sparkles',
                'defaults' => [
                    'brand_name' => 'Shakespeare Middle East',
                    'tagline' => 'A Timeless Dining Experience, Reimagined for Modern Hospitality',
                    'badge' => 'Portfolio Brand',
                    'bg_image' => 'images/platinum/brands/shakespeare.jpg',
                ],
                'fields' => [
                    ['key' => 'brand_name', 'label' => 'Brand Name', 'type' => 'text'],
                    ['key' => 'tagline', 'label' => 'Brand Tagline', 'type' => 'text'],
                    ['key' => 'badge', 'label' => 'Top Badge', 'type' => 'text'],
                    ['key' => 'bg_image', 'label' => 'Background Image', 'type' => 'media'],
                ],
            ],
            'plat_brand_story' => [
                'name' => 'Brand Narrative & Menu Overview',
                'description' => 'Special Menu, culinary essence, and Platinum Hospitality management governance',
                'icon' => 'book-open',
                'defaults' => [
                    'heading' => 'Our Special Menu',
                    'subheading' => 'A Timeless Dining Experience, Reimagined for Modern Hospitality',
                    'description' => '',
                    'management_statement' => '',
                    'image' => 'images/platinum/brands/shakespeare.jpg',
                    'location' => 'United Arab Emirates',
                ],
                'fields' => [
                    ['key' => 'heading', 'label' => 'Heading', 'type' => 'text'],
                    ['key' => 'subheading', 'label' => 'Subheading', 'type' => 'text'],
                    ['key' => 'description', 'label' => 'Detailed Description', 'type' => 'textarea'],
                    ['key' => 'management_statement', 'label' => 'Platinum Management Statement', 'type' => 'textarea'],
                    ['key' => 'image', 'label' => 'Showcase Photo', 'type' => 'media'],
                    ['key' => 'location', 'label' => 'Location Details', 'type' => 'text'],
                ],
            ],
            'plat_brand_experience' => [
                'name' => 'Brand Experience & Cultural Pillars',
                'description' => 'Experience the world of brand with 3 highlight cards',
                'icon' => 'grid',
                'defaults' => [
                    'badge' => 'Signature Journey',
                    'title' => 'Experience the World of Shakespeare Middle East',
                    'subtitle' => 'A Celebration of Heritage, Flavor, and Ambiance',
                ],
                'fields' => [
                    ['key' => 'badge', 'label' => 'Badge', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Section Title', 'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea'],
                ],
            ],
        ];
    }
}
