/* ==========================================================================
   369 HealthDex Admin — shared notification system.
   Replaces browser alert()/confirm() with toasts + a confirm modal, styled
   to match admin-premium.css. Loaded once in admin/layout/index.blade.php,
   available globally as window.admNotify on every admin page.
   ========================================================================== */
(function (window, document) {
  "use strict";

  var ICONS = {
    success: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>',
    error: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
    warning: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>',
    info: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>'
  };

  var DEFAULT_TITLES = {
    success: "Success",
    error: "Something went wrong",
    warning: "Please check",
    info: "Notice"
  };

  function ensureStack() {
    var stack = document.querySelector(".adm-notify-stack");
    if (!stack) {
      stack = document.createElement("div");
      stack.className = "adm-notify-stack";
      document.body.appendChild(stack);
    }
    return stack;
  }

  function toast(message, type, title, duration) {
    type = ICONS[type] ? type : "info";
    duration = duration || 4500;
    var stack = ensureStack();

    var el = document.createElement("div");
    el.className = "adm-notify-toast adm-notify-toast--" + type;
    el.setAttribute("role", "status");

    var iconWrap = document.createElement("span");
    iconWrap.className = "adm-notify-icon";
    iconWrap.innerHTML = ICONS[type];

    var body = document.createElement("div");
    body.className = "adm-notify-body";

    if (title !== false) {
      var titleEl = document.createElement("b");
      titleEl.className = "adm-notify-title";
      titleEl.textContent = title || DEFAULT_TITLES[type];
      body.appendChild(titleEl);
    }

    var msgEl = document.createElement("span");
    msgEl.className = "adm-notify-msg";
    msgEl.textContent = message || "";
    body.appendChild(msgEl);

    var closeBtn = document.createElement("button");
    closeBtn.type = "button";
    closeBtn.className = "adm-notify-close";
    closeBtn.setAttribute("aria-label", "Close");
    closeBtn.innerHTML = "&times;";

    el.appendChild(iconWrap);
    el.appendChild(body);
    el.appendChild(closeBtn);
    stack.appendChild(el);

    requestAnimationFrame(function () {
      requestAnimationFrame(function () { el.classList.add("is-shown"); });
    });

    var timer = setTimeout(close, duration);
    closeBtn.addEventListener("click", function () { close(); });

    function close() {
      if (el.__closed) { return; }
      el.__closed = true;
      clearTimeout(timer);
      el.classList.remove("is-shown");
      el.classList.add("is-leaving");
      setTimeout(function () { el.remove(); }, 220);
    }

    return close;
  }

  function confirmModal(message, opts) {
    opts = opts || {};
    return new Promise(function (resolve) {
      var overlay = document.createElement("div");
      overlay.className = "adm-confirm-overlay";

      var modal = document.createElement("div");
      modal.className = "adm-confirm-modal";

      var iconWrap = document.createElement("div");
      iconWrap.className = "adm-confirm-icon " + (opts.danger ? "adm-confirm-icon--danger" : "adm-confirm-icon--default");
      iconWrap.innerHTML = opts.danger ? ICONS.warning : ICONS.info;

      var titleEl = document.createElement("h5");
      titleEl.className = "adm-confirm-title";
      titleEl.textContent = opts.title || "Are you sure?";

      var msgEl = document.createElement("p");
      msgEl.className = "adm-confirm-msg";
      msgEl.textContent = message || "";

      var actions = document.createElement("div");
      actions.className = "adm-confirm-actions";

      var cancelBtn = document.createElement("button");
      cancelBtn.type = "button";
      cancelBtn.className = "btn-secondary";
      cancelBtn.textContent = opts.cancelText || "Cancel";

      var okBtn = document.createElement("button");
      okBtn.type = "button";
      okBtn.className = "adm-btn-primary" + (opts.danger ? " adm-btn-danger" : "");
      okBtn.textContent = opts.confirmText || "Confirm";

      actions.appendChild(cancelBtn);
      actions.appendChild(okBtn);
      modal.appendChild(iconWrap);
      modal.appendChild(titleEl);
      modal.appendChild(msgEl);
      modal.appendChild(actions);
      overlay.appendChild(modal);
      document.body.appendChild(overlay);

      requestAnimationFrame(function () {
        requestAnimationFrame(function () { overlay.classList.add("is-shown"); });
      });

      function finish(result) {
        overlay.classList.remove("is-shown");
        setTimeout(function () { overlay.remove(); }, 180);
        document.removeEventListener("keydown", onKeydown);
        resolve(result);
      }
      function onKeydown(e) {
        if (e.key === "Escape") { finish(false); }
      }

      cancelBtn.addEventListener("click", function () { finish(false); });
      okBtn.addEventListener("click", function () { finish(true); });
      overlay.addEventListener("click", function (e) { if (e.target === overlay) { finish(false); } });
      document.addEventListener("keydown", onKeydown);
      okBtn.focus();
    });
  }

  window.admNotify = {
    success: function (message, title, duration) { return toast(message, "success", title, duration); },
    error: function (message, title, duration) { return toast(message, "error", title, duration); },
    warning: function (message, title, duration) { return toast(message, "warning", title, duration); },
    info: function (message, title, duration) { return toast(message, "info", title, duration); },
    confirm: confirmModal
  };
})(window, document);
