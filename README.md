# VideoProjects WordPress Theme

Custom WordPress theme for VideoProjects website with WooCommerce and ACF support.


# VideoProjects — Custom WooCommerce Theme

**Role:** WordPress/WooCommerce Developer  
**Stack:** WordPress, WooCommerce, PHP, HTML/CSS, JavaScript, ACF, Bootstrap 5  

---

## Project Goal
The client needed a **custom WordPress theme** for a media-oriented business with an integrated online shop and content blocks managed through ACF. The goal was to combine a product catalog, services, and media presentation in one website.

---

## My Contribution
- Customized a WordPress theme with WooCommerce integration.  
- Implemented ACF fields for dynamic content sections (hero, services, FAQ, news).  
- Built responsive layouts with Bootstrap 5 for mobile-first design.  
- Styled WooCommerce templates (shop, cart, checkout) to match the brand.  
- Ensured cross-browser compatibility (Chrome, Firefox, Safari, Edge, IE11).  

---

## Challenges & Solutions
- **Challenge:** Needed to make a highly flexible home page with multiple custom blocks.  
  **Solution:** Created modular ACF groups (`hero`, `services`, `FAQ`, etc.) and synced them via JSON for easy reuse and migration.  

---

## Results
- Delivered a **custom WordPress theme** tailored to the client’s needs.  
- Client can now manage all homepage sections via the WordPress admin without touching code.  
- The website supports full **e-commerce functionality** with WooCommerce.  

---

## Notes
- My focus was on **frontend development and theme customization**.  
- Additional plugin integrations (forms, payments) were handled by other team members.  

---



# Developer Documentation


## Features

- **WordPress 6.0+ Compatible**
- **WooCommerce Support** - Full e-commerce functionality
- **ACF Pro Integration** - Advanced Custom Fields for content management
- **Responsive Design** - Mobile-first approach
- **Bootstrap 5** - Modern CSS framework
- **Custom Post Types** - For services, projects, etc.
- **SEO Optimized** - Clean code and semantic markup

## Installation

1. **Upload Theme Files**

   - Upload the `VideoProjects` folder to `/wp-content/themes/`
   - Or use WordPress admin: Appearance > Themes > Add New > Upload Theme

2. **Activate Theme**

   - Go to Appearance > Themes
   - Activate "VideoProjects" theme

3. **Install Required Plugins**

   - **Advanced Custom Fields PRO** - Required for custom fields
   - **WooCommerce** - For e-commerce functionality
   - **Gravity Forms** - For contact forms (optional)

4. **Import ACF Fields**
   - Go to Custom Fields > Tools
   - Import the JSON file from `/acf-json/group_home_page_fields.json`

## Theme Structure

```
VideoProjects/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── videos/
│   └── bootstrap/
├── acf-json/
│   └── group_home_page_fields.json
├── html/ (original HTML files)
├── header.php
├── footer.php
├── home.php
├── page-home.php
├── functions.php
├── style.css
└── README.md
```

## ACF Fields

The theme includes pre-configured ACF fields for the home page:

### Galvenās lapas lauki (`group_home_page_fields.json`)

- **Hero sekcija**

  - Galvenais virsraksts
  - Apakšvirsraksts
  - Uzticības reitinga sekcija (lietotāju skaits, uzņēmumu skaits, reitinga vērtējums)
  - Hero video faili (atkārtošanās lauks)

- **Zīmolu logotipi**

  - Galerijas lauks zīmolu logotipiem

- **Pakalpojumu sekcija**

  - Sekcijas virsraksts un apraksts
  - Pakalpojumu saraksts (atkārtošanās ar ikonu, nosaukumu, aprakstu)

- **Jaunumu sekcija**

  - Sekcijas virsraksts
  - Saistītie raksti (sakarības lauks)
  - Pogas teksts un saite

- **BUJ sekcija**

  - Sekcijas virsraksts
  - BUJ elementi (atkārtošanās ar jautājumu un atbildi)

## Usage

### Creating a Home Page

1. Create a new page in WordPress admin
2. Set the page template to "Galvenā lapa"
3. Fill in the ACF fields in the page editor
4. Set this page as your front page in Settings > Reading

### Customizing Styles

- Main styles are in `/assets/css/style.css`
- SCSS source files are in `/assets/css/style.scss`
- Bootstrap styles are included from `/assets/bootstrap/`

### Adding Custom Fields

1. Create new ACF field groups in WordPress admin
2. Export them as JSON to `/acf-json/` folder
3. The theme will automatically sync JSON files

## WooCommerce Integration

The theme includes full WooCommerce support:

- Product pages
- Shop/catalog pages
- Cart and checkout
- Custom WooCommerce styling

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+

## Development

### Local Development

1. Set up a local WordPress environment
2. Install required plugins
3. Import ACF fields
4. Customize as needed

### Building Assets

The theme uses SCSS for styles. To compile:

```bash
# Install dependencies (if using npm)
npm install

# Compile SCSS
sass assets/css/style.scss assets/css/style.css
```
