/*
 |------------------------------------------------------------------
 | iLAP CMS — client-side JavaScript
 |------------------------------------------------------------------
 | Sidebar toggling · notification count · global search · alerts
 */

(function () {
    'use strict';

    // ── Sidebar toggle (desktop + mobile) ──────────────────
    const sidebar   = document.getElementById('ilap-sidebar');
    const toggleBtn = document.getElementById('ilap-sidebar-toggle');
    const overlay   = document.getElementById('ilap-overlay');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('ilap-sidebar--closed');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar?.classList.add('ilap-sidebar--closed');
        });
    }

    // ── Auto-hide success/error alerts after 5 s ────────────
    document.querySelectorAll('.ilap-alert').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .3s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 350);
        }, 5000);
    });

    // ── Dynamic org colour injection ───────────────────────
    function applyOrgColors() {
        const root  = document.documentElement;
        const meta  = document.querySelector('meta[name="ilap-org"]');
        const color = meta ? meta.content : null;
        if (color && color !== '#1e40af') {
            root.style.setProperty('--ilap-primary',   color);
            root.style.setProperty('--ilap-secondary', adjustBrightness(color, 30));
            root.style.setProperty('--ilap-primary-light', hexToRgba(color, .12));
        }
    }

    function hexToRgba(hex: string, alpha: number): string {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        return `rgba(${r},${g},${b},${alpha})`;
    }

    function adjustBrightness(hex: string, pct: number): string {
        const num = parseInt(hex.slice(1),16);
        const r = Math.min(255, (num >> 16) + pct);
        const g = Math.min(255, ((num >> 8) & 0xff) + pct);
        const b = Math.min(255, (num & 0xff) + pct);
        return `#${((1<<24)|(r<<16)|(g<<8)|b).toString(16).slice(1)}`;
    }

    applyOrgColors();
    window.applyOrgColors = applyOrgColors;

    // ── Keyboard shortcut: ⌘K / Ctrl+K search ─────────────
    document.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const input = document.getElementById('ilap-global-search');
            input?.focus();
        }
        if (e.key === 'Escape') {
            sidebar?.classList.add('ilap-sidebar--closed');
        }
    });

    // ── Notify badge pulse if count > 0 ────────────────────
    (function pulseBadge() {
        const badge = document.getElementById('ilap-notif-count');
        if (badge && badge.textContent !== '0') {
            badge.classList.add('animate-pulse');
        }
    })();

})();
