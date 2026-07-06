(function () {
  'use strict';
  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.querySelector('[data-ccl-risk-modal]');
    if (!modal) { return; }
    var openers = document.querySelectorAll('[data-ccl-open-building-risk-modal]');
    var closers = modal.querySelectorAll('[data-ccl-close-building-risk-modal]');
    var firstField = modal.querySelector('input, textarea, button');
    function openModal(event) {
      if (event) { event.preventDefault(); }
      modal.hidden = false;
      document.documentElement.classList.add('ccl-building-risk-modal-is-open');
      document.body.classList.add('ccl-building-risk-modal-is-open');
      if (firstField) { firstField.focus(); }
    }
    function closeModal() {
      modal.hidden = true;
      document.documentElement.classList.remove('ccl-building-risk-modal-is-open');
      document.body.classList.remove('ccl-building-risk-modal-is-open');
    }
    openers.forEach(function (opener) { opener.addEventListener('click', openModal); });
    closers.forEach(function (closer) { closer.addEventListener('click', closeModal); });
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !modal.hidden) { closeModal(); }
    });
    if (modal.getAttribute('data-ccl-open-on-load') === 'true') { openModal(); }
  });
}());
