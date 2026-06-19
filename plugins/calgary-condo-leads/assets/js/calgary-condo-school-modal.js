(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.querySelector('[data-ccl-school-finder-modal]');
    if (!modal) { return; }

    var iframe = modal.querySelector('[data-ccl-school-finder-iframe]');
    var message = modal.querySelector('[data-ccl-school-finder-message]');
    var tabs = modal.querySelectorAll('[data-ccl-school-finder-url]');
    var closers = modal.querySelectorAll('[data-ccl-school-finder-close]');

    function resetFrame() {
      if (iframe) {
        iframe.removeAttribute('src');
        iframe.hidden = true;
      }
      if (message) {
        message.hidden = false;
        message.textContent = 'School finder link is being connected.';
      }
    }

    function openModal() {
      modal.hidden = false;
      document.documentElement.classList.add('ccl-school-finder-modal-is-open');
      document.body.classList.add('ccl-school-finder-modal-is-open');
      resetFrame();
    }

    function closeModal() {
      modal.hidden = true;
      document.documentElement.classList.remove('ccl-school-finder-modal-is-open');
      document.body.classList.remove('ccl-school-finder-modal-is-open');
      resetFrame();
    }

    function loadSchoolFinder(url) {
      if (!url || url === '#') {
        resetFrame();
        return;
      }

      if (message) {
        message.hidden = true;
      }
      if (iframe) {
        iframe.src = url;
        iframe.hidden = false;
      }
    }

    document.querySelectorAll('[data-ccl-school-modal-url], [data-ccl-open-school-finder-modal]').forEach(function (trigger) {
      trigger.addEventListener('click', function (event) {
        event.preventDefault();
        openModal();
      });
    });

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        loadSchoolFinder(tab.getAttribute('data-ccl-school-finder-url'));
      });
    });

    closers.forEach(function (closer) {
      closer.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !modal.hidden) {
        closeModal();
      }
    });
  });
}());
