import labels from '../labels';
import formState from '../state';

/**
 * Get the html markup for the customer details section of the modal.
 *
 * @since 4.5.3
 *
 * @returns {string} Section html markup.
 */
export default function customerDetailsSectionMarkup() {
  return `
  <div class="acfw-send-coupon-form-section ${
    formState.get('section') === 'customer_details' ? 'current' : ''
  }" data-section="customer_details">
    <div class="section-number">
      <span>2</span>
    </div>
    <div class="section-inner">
      <h3>${getSectionTitle(formState.get('option'))}</h3>
      <div class="section-content">
        ${getSectionContent(formState.get('option'))}
        <button type="button" class="button-primary acfw-next-section-btn" data-next_section="confirm_and_send">${
          labels.next
        }</button>
      </div>
    </div>
  </div>
  `;
}

/**
 * Get the title for the "details" section of the modal.
 *
 * @since 4.6.x
 *
 * @param {string} option The option to pass to the section renderer.
 * @returns {string} Section HTML markup.
 */
function getSectionTitle(option: string) {
  switch (option) {
    case 'email':
      return labels.email.customer_details;
    case 'pushengage':
      return labels.pushengage.details;
  }
  return '';
}

/**
 * Get the HTML markup for the "details" section of the modal.
 *
 * @since 4.6.x
 *
 * @param {string} option The option to pass to the section renderer.
 * @returns {string} Section HTML markup.
 */
function getSectionContent(option: string) {
  switch (option) {
    case 'email':
      return `<div class="customer-details-form user-form show">
          <select data-placeholder="${labels.email.search}" name="acfw_send_coupon[user]" data-key="user" class="wc-customer-search" style="width:100%"></select>
        </div>
        <div class="customer-details-form guest-form">
          <input type="text" placeholder="${labels.email.name}" name="acfw_send_coupon[name]" data-key="name" />
          <input type="email" placeholder="${labels.email.email}" name="acfw_send_coupon[email]" data-key="email" />
          <label>
            <input type="checkbox" data-key="create_account" value="yes" /> 
            <span>${labels.email.create_new_user_account}</span>
        </div>`;
    case 'pushengage':
      return `<div class="message-form show">
          <div>
            <label>${labels.pushengage.title}</label>
            <input type="text" placeholder="${labels.pushengage.title_placeholder}" value="${formState.get(
        'title'
      )}" name="acfw_send_coupon[title]" data-key="title" />
          </div>
          <div>
            <label>${labels.pushengage.message}</label>
            <input type="text" placeholder="${labels.pushengage.message_placeholder}" value="${formState.get(
        'message'
      )}" name="acfw_send_coupon[message]" data-key="message" />
          </div>
          <div>
            <label>${labels.pushengage.url}</label>
            <input type="text" placeholder="${labels.pushengage.url_placeholder}" value="${formState.get(
        'url'
      )}" name="acfw_send_coupon[url]" data-key="url" />
          </div>
      </div>`;
  }
  return '';
}
