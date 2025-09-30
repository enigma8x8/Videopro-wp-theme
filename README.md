# VideoProjects WordPress Theme

Custom WordPress theme for VideoProjects website with WooCommerce and ACF support.

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

## Support

For theme support and customization, contact the development team.

## License

This theme is proprietary and confidential. All rights reserved.
