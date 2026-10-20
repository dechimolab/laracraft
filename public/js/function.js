/**
 * ArtisanCraft Engine - Global Functions & Utilities
 * Location: public/js/function.js
 * Consolidated client-side helpers, theme manager, hotkeys, and utilities
 */

(function (window, document) {
    'use strict';

    /**
     * Escape HTML special characters for safe template interpolation
     * @param {string|null} str
     * @returns {string}
     */
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    /**
     * Copy text to clipboard with modern navigator.clipboard and fallback
     * @param {string} text
     * @param {string} [successMsg]
     * @returns {Promise<boolean>}
     */
    async function copyToClipboard(text, successMsg) {
        if (!text) return false;
        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                document.execCommand('copy');
                textArea.remove();
            }

            if (successMsg && window.artisanNotify) {
                window.artisanNotify.success(successMsg);
            }
            return true;
        } catch (err) {
            console.error('Failed to copy text:', err);
            if (window.artisanNotify) {
                window.artisanNotify.error('ไม่สามารถคัดลอกข้อความได้');
            }
            return false;
        }
    }

    /**
     * Copy snippet with automatic button icon animation (reverts to checkmark and back)
     * @param {HTMLElement|string} btn - Button element or selector
     * @param {string} textToCopy - The content to copy
     * @param {string} [successMsg] - Optional message for toast
     * @returns {Promise<boolean>}
     */
    async function copySnippet(btn, textToCopy, successMsg) {
        const btnEl = typeof btn === 'string' ? document.querySelector(btn) : btn;
        const success = await copyToClipboard(textToCopy, successMsg);

        if (success && btnEl) {
            const iconEl = btnEl.querySelector('.material-symbols-outlined') || btnEl.querySelector('span');
            const originalIcon = iconEl ? iconEl.textContent : '';
            if (iconEl) {
                iconEl.textContent = 'check';
                iconEl.classList.add('text-emerald-400');
            }
            btnEl.classList.add('ring-1', 'ring-emerald-400/50');

            setTimeout(() => {
                if (iconEl) {
                    iconEl.textContent = originalIcon || 'content_copy';
                    iconEl.classList.remove('text-emerald-400');
                }
                btnEl.classList.remove('ring-1', 'ring-emerald-400/50');
            }, 1500);
        }

        return success;
    }

    /**
     * Universal Notification Wrapper with SweetAlert2 integration
     */
    const artisanNotify = {
        success: function (title, text) {
            const config = {
                icon: 'success',
                title: title || 'สำเร็จ',
                text: text || '',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'ตกลง'
            };
            if (window.ArtisanSwal) {
                return window.ArtisanSwal.fire(config);
            } else if (typeof Swal !== 'undefined') {
                return Swal.fire(config);
            } else {
                alert(title + (text ? '\n' + text : ''));
            }
        },

        error: function (title, text) {
            if (window.ArtisanSwal) {
                return window.ArtisanSwal.fire({
                    icon: 'error',
                    title: title || 'เกิดข้อผิดพลาด',
                    text: text || ''
                });
            } else if (typeof Swal !== 'undefined') {
                return Swal.fire({
                    icon: 'error',
                    title: title || 'เกิดข้อผิดพลาด',
                    text: text || ''
                });
            } else {
                alert(title + (text ? '\n' + text : ''));
            }
        },

        info: function (title, text) {
            if (window.ArtisanSwal) {
                return window.ArtisanSwal.fire({
                    icon: 'info',
                    title: title || 'แจ้งเตือน',
                    text: text || ''
                });
            } else if (typeof Swal !== 'undefined') {
                return Swal.fire({
                    icon: 'info',
                    title: title || 'แจ้งเตือน',
                    text: text || ''
                });
            } else {
                alert(title + (text ? '\n' + text : ''));
            }
        },

        confirm: async function (title, text, confirmBtnText = 'ยืนยัน', cancelBtnText = 'ยกเลิก') {
            if (window.ArtisanSwal) {
                const res = await window.ArtisanSwal.fire({
                    icon: 'warning',
                    title: title,
                    text: text,
                    showCancelButton: true,
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: cancelBtnText,
                    confirmButtonColor: '#ff5542',
                    cancelButtonColor: '#222a3d'
                });
                return res.isConfirmed;
            } else if (typeof Swal !== 'undefined') {
                const res = await Swal.fire({
                    icon: 'warning',
                    title: title,
                    text: text,
                    showCancelButton: true,
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: cancelBtnText
                });
                return res.isConfirmed;
            }
            return window.confirm(title + (text ? '\n' + text : ''));
        }
    };

    /**
     * WebAuthn / Binary Crypto Utilities
     */
    const artisanCrypto = {
        base64urlToUint8Array: function (base64url) {
            let padding = '='.repeat((4 - base64url.length % 4) % 4);
            let base64 = (base64url + padding).replace(/-/g, '+').replace(/_/g, '/');
            let raw = window.atob(base64);
            let output = new Uint8Array(raw.length);
            for (let i = 0; i < raw.length; ++i) {
                output[i] = raw.charCodeAt(i);
            }
            return output;
        },

        bufferToBase64url: function (buffer) {
            let bytes = new Uint8Array(buffer);
            let binary = '';
            for (let i = 0; i < bytes.byteLength; i++) {
                binary += String.fromCharCode(bytes[i]);
            }
            return window.btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
        }
    };

    /* ==========================================================================
       Layout UI Mechanics (Topbar, Dropdowns, Modals, Hotkeys, Theme)
       ========================================================================== */

    // 1. Project Switcher Dropdown
    function toggleProjectDropdown() {
        const menu = document.getElementById('project-dropdown-menu');
        const arrow = document.getElementById('project-dropdown-arrow');
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        } else {
            menu.classList.add('hidden');
            if (arrow) arrow.style.transform = '';
        }
    }

    // 2. Command Palette (Ctrl+K)
    function openCommandPalette() {
        const modal = document.getElementById('palette-modal');
        const input = document.getElementById('palette-input');
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            if (input) {
                input.value = '';
                input.focus();
                filterPaletteResults('');
            }
        }, 50);
    }

    function closeCommandPalette() {
        const modal = document.getElementById('palette-modal');
        if (modal) modal.classList.add('hidden');
    }

    function closePaletteOnBackdrop(e) {
        if (e && e.target && e.target.id === 'palette-modal') {
            closeCommandPalette();
        }
    }

    function filterPaletteResults(query) {
        const term = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.palette-item');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? 'flex' : 'none';
        });
    }

    // 3. Docs Modal
    function openDocsModal() {
        const modal = document.getElementById('docs-modal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeDocsModal(e) {
        if (!e || (e.target && e.target.id === 'docs-modal')) {
            const modal = document.getElementById('docs-modal');
            if (modal) modal.classList.add('hidden');
        }
    }

    // 4. Dark / Light Theme Mode Toggle
    function updateThemeUI(theme) {
        const icon = document.getElementById('theme-toggle-icon');
        const btn = document.getElementById('theme-toggle-btn');
        if (theme === 'light') {
            document.documentElement.classList.remove('dark');
            if (icon) icon.textContent = 'dark_mode';
            if (btn) btn.setAttribute('title', 'สลับเป็นโหมดมืด (Dark Mode)');
        } else {
            document.documentElement.classList.add('dark');
            if (icon) icon.textContent = 'light_mode';
            if (btn) btn.setAttribute('title', 'สลับเป็นโหมดสว่าง (Light Mode)');
        }
    }

    function initThemeMode() {
        let savedTheme = 'dark';
        try {
            savedTheme = localStorage.getItem('artisan_theme') || 'dark';
        } catch(e) {}
        updateThemeUI(savedTheme);
    }

    function toggleThemeMode() {
        const isDark = document.documentElement.classList.contains('dark');
        const newTheme = isDark ? 'light' : 'dark';
        try {
            localStorage.setItem('artisan_theme', newTheme);
        } catch(e) {}
        updateThemeUI(newTheme);
    }

    // Document Events Setup
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('project-dropdown-wrapper');
        const menu = document.getElementById('project-dropdown-menu');
        const arrow = document.getElementById('project-dropdown-arrow');
        if (wrapper && !wrapper.contains(e.target) && menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
            if (arrow) arrow.style.transform = '';
        }
    });

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
            e.preventDefault();
            openCommandPalette();
        }
        if (e.key === 'Escape') {
            closeCommandPalette();
            closeDocsModal();
        }
    });

    // Initialize Theme Mode on page load
    document.addEventListener('DOMContentLoaded', initThemeMode);

    // SweetAlert2 Custom Default Mixin
    window.ArtisanSwal = typeof Swal !== 'undefined' ? Swal.mixin({
        customClass: {
            popup: 'artisan-swal-popup',
            title: 'artisan-swal-title',
            htmlContainer: 'artisan-swal-html',
            confirmButton: 'artisan-swal-confirm',
            cancelButton: 'artisan-swal-cancel',
            input: 'artisan-swal-input'
        },
        buttonsStyling: false
    }) : null;

    /**
     * Workspace & DevTools Utilities (Tabs, Viewport, File Tree Filter, Code Sizing)
     */
    const artisanWorkspace = {
        switchTab: function (tab) {
            document.querySelectorAll('.workspace-tab').forEach(btn => {
                btn.classList.remove('active-tab', 'border-primary', 'text-primary', 'font-semibold');
                btn.classList.add('border-transparent', 'text-on-surface-variant');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });

            const activeBtn = document.getElementById('btn-tab-' + tab);
            const activePane = document.getElementById('pane-' + tab);
            if (activeBtn) {
                activeBtn.classList.remove('border-transparent', 'text-on-surface-variant');
                activeBtn.classList.add('active-tab', 'border-primary', 'text-primary', 'font-semibold');
            }
            if (activePane) {
                activePane.classList.remove('hidden');
            }
        },

        setViewport: function (mode, iframeId = 'preview-iframe') {
            const iframe = document.getElementById(iframeId);
            if (!iframe) return;
            if (mode === 'desktop') {
                iframe.style.maxWidth = '100%';
            } else if (mode === 'tablet') {
                iframe.style.maxWidth = '768px';
            } else if (mode === 'mobile') {
                iframe.style.maxWidth = '390px';
            }
        },

        displayCode: function (code, filename, targetCodeId = 'code-display', targetBadgeId = 'file-size-badge') {
            const display = document.getElementById(targetCodeId);
            if (display) {
                display.textContent = code;
            }

            const badge = document.getElementById(targetBadgeId);
            if (badge) {
                const bytes = new Blob([code]).size;
                let formattedSize = bytes + ' B';
                if (bytes >= 1024) {
                    formattedSize = (bytes / 1024).toFixed(1) + ' KB';
                }
                const lines = code.split('\n').length;
                badge.textContent = `${lines} lines • ${formattedSize}`;
            }
        },

        filterFileTree: function (query, fileNodeSelector = '.file-node', dirGroupSelector = '.dir-group') {
            const q = (query || '').toLowerCase().trim();
            document.querySelectorAll(fileNodeSelector).forEach(node => {
                const text = node.textContent.toLowerCase();
                const path = (node.getAttribute('data-path') || '').toLowerCase();
                if (text.includes(q) || path.includes(q)) {
                    node.style.display = 'flex';
                } else {
                    node.style.display = 'none';
                }
            });

            document.querySelectorAll(dirGroupSelector).forEach(group => {
                if (!q) {
                    group.style.display = 'flex';
                    return;
                }
                const hasVisibleChild = Array.from(group.querySelectorAll(fileNodeSelector)).some(n => n.style.display !== 'none');
                group.style.display = hasVisibleChild ? 'flex' : 'none';
            });
        }
    };

    // Expose helpers globally on window object
    window.escapeHtml = escapeHtml;
    window.copyToClipboard = copyToClipboard;
    window.copySnippet = copySnippet;
    window.artisanNotify = artisanNotify;
    window.artisanCrypto = artisanCrypto;
    window.artisanWorkspace = artisanWorkspace;
    window.toggleProjectDropdown = toggleProjectDropdown;
    window.openCommandPalette = openCommandPalette;
    window.closeCommandPalette = closeCommandPalette;
    window.closePaletteOnBackdrop = closePaletteOnBackdrop;
    window.filterPaletteResults = filterPaletteResults;
    window.openDocsModal = openDocsModal;
    window.closeDocsModal = closeDocsModal;
    window.updateThemeUI = updateThemeUI;
    window.initThemeMode = initThemeMode;
    window.toggleThemeMode = toggleThemeMode;

})(window, document);
