(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('ccl-unified-lead-modal');
    if (!modal) { return; }

    var context = modal.querySelector('[data-ccl-lead-context]');
    var submit = modal.querySelector('[data-ccl-lead-submit]');
    var firstField = modal.querySelector('input:not([type="hidden"]), textarea, button');
    var previousOverflow = '';
    var fields = {
      leadSource: modal.querySelector('#ccl_lead_source'),
      requestedCategory: modal.querySelector('#ccl_requested_category'),
      requestedPage: modal.querySelector('#ccl_requested_page'),
      requestedUrl: modal.querySelector('#ccl_requested_url'),
      intent: modal.querySelector('#ccl_intent')
    };

    function defaultPageTitle() {
      return document.title || window.location.href;
    }

    function setField(field, value) {
      if (field) {
        field.value = value || '';
      }
    }

    function openModal(trigger) {
      var leadSource = trigger.getAttribute('data-lead-source') || 'Calgary Condo Portal';
      var requestedCategory = trigger.getAttribute('data-requested-category') || 'General Calgary Condo Help';
      var intent = trigger.getAttribute('data-intent') || 'General inquiry';
      var ctaText = /risk/i.test(intent + ' ' + requestedCategory) ? 'Send Me the Building Risk Report' : 'Send Me the Active Condo List';

      setField(fields.leadSource, leadSource);
      setField(fields.requestedCategory, requestedCategory);
      setField(fields.requestedPage, defaultPageTitle());
      setField(fields.requestedUrl, window.location.href);
      setField(fields.intent, intent);

      if (context) {
        context.textContent = 'You\u2019re requesting: ' + requestedCategory;
      }
      if (submit) {
        submit.textContent = ctaText;
      }

      previousOverflow = document.body.style.overflow;
      document.body.style.overflow = 'hidden';
      document.documentElement.classList.add('ccl-unified-lead-modal-is-open');
      document.body.classList.add('ccl-unified-lead-modal-is-open');
      modal.classList.add('is-active');
      modal.setAttribute('aria-hidden', 'false');

      window.setTimeout(function () {
        if (firstField) { firstField.focus(); }
      }, 25);
    }

    function closeModal() {
      modal.classList.remove('is-active');
      modal.setAttribute('aria-hidden', 'true');
      document.documentElement.classList.remove('ccl-unified-lead-modal-is-open');
      document.body.classList.remove('ccl-unified-lead-modal-is-open');
      document.body.style.overflow = previousOverflow;
    }

    document.addEventListener('click', function (event) {
      const trigger = event.target.closest('[data-ccl-lead-open]');
      var legacyTrigger = trigger || event.target.closest('a[href="#condo-alerts"]');
      if (legacyTrigger) {
        event.preventDefault();
        openModal(legacyTrigger);
        return;
      }

      if (event.target.closest('[data-ccl-lead-close]')) {
        event.preventDefault();
        closeModal();
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && modal.classList.contains('is-active')) {
        closeModal();
      }
    });
  });
}());
