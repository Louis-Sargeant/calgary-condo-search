(function () {
  'use strict';
  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.querySelector('[data-ccl-school-modal]');
    if (!modal) { return; }
    var iframe = modal.querySelector('[data-ccl-school-modal-iframe]');
    var message = modal.querySelector('[data-ccl-school-modal-message]');
    var closers = modal.querySelectorAll('[data-ccl-school-modal-close]');
    function openModal(url) {
      modal.hidden = false;
      document.documentElement.classList.add('ccl-school-modal-is-open');
      document.body.classList.add('ccl-school-modal-is-open');
      if (url && url !== '#') {
        iframe.src = url;
        iframe.hidden = false;
        message.hidden = true;
      } else {
        iframe.removeAttribute('src');
        iframe.hidden = true;
        message.hidden = false;
      }
    }
    function closeModal() {
      modal.hidden = true;
      document.documentElement.classList.remove('ccl-school-modal-is-open');
      document.body.classList.remove('ccl-school-modal-is-open');
      iframe.removeAttribute('src');
    }
    document.querySelectorAll('[data-ccl-school-modal-url]').forEach(function (trigger) {
      trigger.addEventListener('click', function (event) {
        event.preventDefault();
        openModal(trigger.getAttribute('href') || trigger.getAttribute('data-ccl-school-modal-url'));
      });
    });
    closers.forEach(function (closer) { closer.addEventListener('click', closeModal); });
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !modal.hidden) { closeModal(); }
    });
  });
}());
