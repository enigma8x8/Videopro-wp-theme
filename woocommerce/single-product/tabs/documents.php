<?php

/**
 * Documents tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/documents.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

global $product;

$attached_documents = get_field('attached_documents', $product->get_id());

if ($attached_documents && is_array($attached_documents)) : ?>
    <div class="documents-list">
        <?php foreach ($attached_documents as $document) :
            $document_title = $document['document_title'];
            $document_file = $document['document_file'];

            if ($document_title && $document_file) : ?>
                <div class="document-item">
                    <a href="<?php echo esc_url($document_file['url']); ?>"
                        class="document-link"
                        target="_blank"
                        download="<?php echo esc_attr($document_file['filename']); ?>">
                        <span class="document-title"><?php echo esc_html($document_title); ?></span>
                        <span class="document-extension"><?php echo esc_html($document_file['subtype']); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p><?php esc_html_e('Nav pievienotu dokumentu.', 'videoprojects'); ?></p>
<?php endif; ?>