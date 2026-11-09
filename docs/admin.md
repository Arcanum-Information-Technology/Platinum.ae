# Admin Panel User Manual & Operations Guide

Welcome to the **Restaurant Management & CMS Dashboard**. This guide assists restaurant managers, head chefs, and marketing staff in operating the digital storefront without requiring technical code knowledge.

---

## 1. Access & Security

- **Login URL**: `https://yourdomain.com/admin/login`
- **Initial Credentials**: Created during setup (see `README.md`).
- **Security Rule**: Upon first login, click your profile name at the top right and update your password immediately.

---

## 2. Admin Navigation Overview

| Section | Menu Item | Purpose |
|---------|-----------|---------|
| **Overview** | **Dashboard** | Real-time counts of menu items, published pages, unread messages, and recent audit activity. |
| **Website** | **Pages** | Create, edit, and organize website pages using the visual section builder. |
| | **Navigation** | Edit Header and Footer navigation menus, ordering, and links. |
| | **Redirects** | Create 301/302 redirects when URLs change to preserve Google search rankings. |
| **Restaurant** | **Categories** | Parent cuisines (e.g., Italian, Indian, Desserts, Beverages). |
| | **Subcategories** | Sub-levels (e.g., Starters, Main Course, Breads, Pastas). |
| | **Menu Items** | Dishes, prices, dietary badges, ingredients, allergens, and gallery pictures. |
| | **Offers** | Special promotions, seasonal discounts, and promotional banners. |
| | **Opening Hours** | Set opening/closing times per day, including lunch & dinner split shifts. |
| | **Restaurant Info**| Address, phone, coordinates, and contact details. |
| **Media** | **Media Library** | Upload, preview, and organize high-resolution dish and restaurant photography. |
| **Messages** | **Contact Messages**| Review incoming customer reservations and inquiry submissions. |
| **Access** | **Users & Roles** | Invite staff members and restrict access by role (Super Admin, Menu Manager, Content Manager). |
| **Settings** | **Global Settings** | Site title, restaurant logo, favicon, social media links, and Google Analytics. |

---

## 3. Step-by-Step Operator Workflows

### How to Add a New Dish to the Menu
1. Go to **Restaurant** -> **Menu Items** -> Click **+ Add Menu Item**.
2. Fill in:
   - **Name**: e.g., *"Truffle Tagliolini"*
   - **Category & Subcategory**: Select appropriate cuisine and sub-level.
   - **Price**: Regular price (and optional discounted promotional price).
   - **Primary Image**: Pick an image from the Media Library or upload a new photo.
   - **Dietary Flags**: Check Vegetarian, Vegan, or Spicy if applicable.
   - **Details**: Add ingredients (comma-separated), allergens, calories, and preparation time.
3. Set **Status** to `Active` and click **Save Menu Item**.
4. The dish immediately reflects on the public `/menu` page and in Google's structured data.

### How to Edit Homepage Sections with the Page Builder
1. Go to **Website** -> **Pages** -> Click **Edit** next to the **Home** page.
2. In the **Page Sections** panel:
   - To reorder: Adjust the **Sort Order** numbers.
   - To toggle visibility: Switch the **Active** toggle on or off.
   - To edit content: Click **Edit Section** to modify titles, subtitles, call-to-action buttons, or background images.
   - To add a new block: Select a section type (e.g. *Featured Food*, *Testimonials*, *FAQ*) from the dropdown and click **Add Section**.
3. Click **Save Page** to deploy changes.

### How to Update Restaurant Opening Hours
1. Go to **Restaurant** -> **Opening Hours**.
2. For each day of the week (Monday through Sunday):
   - Set Shift 1 (e.g., 11:30 AM to 03:00 PM).
   - Set Shift 2 (e.g., 05:30 PM to 10:30 PM) for split service.
   - Check **Closed** for rest days or private event days.
3. Click **Save Hours**. The footer, contact page, and Google Schema automatically reflect the updated hours.

### How to Manage Customer Contact Messages
1. Go to **Messages** -> **Contact Messages**.
2. The badge indicates unread inquiries.
3. Click any message to view customer contact info, phone number, and message text.
4. Messages can be marked as read, archived, or deleted once attended to.

---

## 4. Role Permissions Matrix

- **Super Admin**: Unrestricted access to system configuration, user accounts, and billing.
- **Admin**: Can manage all website content, menu items, media, and settings.
- **Menu Manager**: Restricted to Categories, Subcategories, Menu Items, and Offers.
- **Content Manager**: Restricted to Pages, CMS Sections, Media Library, and Blog/Galleries.
- **SEO Manager**: Restricted to SEO metadata, sitemaps, and redirects.
