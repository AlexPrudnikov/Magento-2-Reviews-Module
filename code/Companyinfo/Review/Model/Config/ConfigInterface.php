<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Companyinfo\Review\Model\Config;

/**
 * Contact module configuration
 *
 * @api
 * @since 100.2.0
 */
interface ConfigInterface
{
	const XML_PATH_META_TITLE = 'review/fields_masks/meta_title';

	const XML_PATH_META_KEYWORD = 'review/fields_masks/meta_keyword';

	const XML_PATH_META_DESCRIPTION = 'review/fields_masks/meta_description';

    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_ADMIN = 'review/email/recipient_email';

    /**
     * Email template add config path
     */
    const XML_PATH_EMAIL_TEMPLATE_ADD = 'review/email/template_add_new_review';

    /**
     * Email template edit config path
     */
    const XML_PATH_EMAIL_TEMPLATE_EDIT = 'review/email/template_edit_review';

    /**
     * Email template change config path
     */
    const XML_PATH_EMAIL_TEMPLATE_CHANGE = 'review/email/template_change_status_review';

    /**
     * Return email template identifier
     *
     * @return string
     * @since 100.2.0
     */
    public function emailTemplateAdd();

    /**
     * Return email template identifier
     *
     * @return string
     * @since 100.2.0
     */
    public function emailTemplateEdit();

    /**
     * Return email template identifier
     *
     * @return string
     * @since 100.2.0
     */
    public function emailTemplateChange();

    /**
     * Return email recipient address
     *
     * @return string
     * @since 100.2.0
     */
    public function emailRecipient();


    /**
     * Return title
     *
     * @return string
     * @since 100.2.0
     */
    public function getTitle();

    /**
     * Return keyword
     *
     * @return string
     * @since 100.2.0
     */
    public function getKeywords();


    /**
     * Return description
     *
     * @return string
     * @since 100.2.0
     */
    public function getDescription();
}
