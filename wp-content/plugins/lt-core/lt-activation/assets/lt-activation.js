/**
 * LT Activation Plugin Admin JavaScript
 */
(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        initActivationForm();
        initFormValidation();
        initLoadingStates();
    });

    /**
     * Initialize activation form
     */
    function initActivationForm() {
        $('.lt-activation-form form').on('submit', function(e) {
            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');
            var $loading = $('.lt-activation-loading');
            
            // Show loading state
            $submitBtn.prop('disabled', true);
            $loading.addClass('show');
            
            // Hide any existing notices
            $('.lt-activation-notice').remove();
            
            // Validate form before submission
            if (!validateForm($form)) {
                e.preventDefault();
                $submitBtn.prop('disabled', false);
                $loading.removeClass('show');
                return false;
            }
        });
    }


    /**
     * Initialize form validation
     */
    function initFormValidation() {
        var $purchaseCode = $('#lt_purchase_code');
        var $email = $('#lt_email');
        var $name = $('#lt_name');
        
        // Real-time validation
        $purchaseCode.on('input', function() {
            validatePurchaseCode($(this));
        });
        
        $email.on('input', function() {
            validateEmail($(this));
        });
        
        $name.on('input', function() {
            validateName($(this));
        });
    }

    /**
     * Initialize loading states
     */
    function initLoadingStates() {
        // Add loading spinner to buttons
        $('.lt-activation-buttons .button').each(function() {
            var $btn = $(this);
            var originalText = $btn.text();
            
            $btn.data('original-text', originalText);
        });
    }


    /**
     * Validate entire form
     */
    function validateForm($form) {
        var isValid = true;
        
        // Validate purchase code
        var $purchaseCode = $form.find('#lt_purchase_code');
        if (!validatePurchaseCode($purchaseCode)) {
            isValid = false;
        }
        
        // Validate email
        var $email = $form.find('#lt_email');
        if (!validateEmail($email)) {
            isValid = false;
        }
        
        // Validate name
        var $name = $form.find('#lt_name');
        if (!validateName($name)) {
            isValid = false;
        }
        
        return isValid;
    }

    /**
     * Validate purchase code
     */
    function validatePurchaseCode($input) {
        var code = $input.val().trim();
        var isValid = true;
        var message = '';
        
        if (code === '') {
            message = 'Purchase code is required.';
            isValid = false;
        } else if (!isValidPurchaseCode(code)) {
            message = 'Invalid purchase code format.';
            isValid = false;
        }
        
        showFieldError($input, message);
        return isValid;
    }

    /**
     * Validate email
     */
    function validateEmail($input) {
        var email = $input.val().trim();
        var isValid = true;
        var message = '';
        
        if (email !== '' && !isValidEmail(email)) {
            message = 'Invalid email format.';
            isValid = false;
        }
        
        showFieldError($input, message);
        return isValid;
    }

    /**
     * Validate name
     */
    function validateName($input) {
        var name = $input.val().trim();
        var isValid = true;
        var message = '';
        
        if (name.length > 255) {
            message = 'Name is too long (max 255 characters).';
            isValid = false;
        } else if (name !== '' && /[<>"']/.test(name)) {
            message = 'Name contains invalid characters.';
            isValid = false;
        }
        
        showFieldError($input, message);
        return isValid;
    }

    /**
     * Show field error
     */
    function showFieldError($input, message) {
        var $field = $input.closest('td');
        var $error = $field.find('.lt-field-error');
        
        // Remove existing error
        $error.remove();
        
        // Add error if message exists
        if (message) {
            $input.addClass('error');
            $field.append('<div class="lt-field-error" style="color: #d63638; font-size: 12px; margin-top: 5px;">' + message + '</div>');
        } else {
            $input.removeClass('error');
        }
    }

    /**
     * Show notice
     */
    function showNotice(message, type) {
        var $notice = $('<div class="lt-activation-notice ' + type + '">' + message + '</div>');
        $('.lt-activation-container').prepend($notice);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $notice.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }

    /**
     * Validate purchase code format
     */
    function isValidPurchaseCode(code) {
        var regex = /^[a-zA-Z0-9\-]+$/;
        return regex.test(code) && code.length >= 8;
    }

    /**
     * Validate email format
     */
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }


    // Export data function
    window.ltActivationExportData = function() {
        // Get activation data
        var activationData = {
            purchase_code: $('.lt-activation-info-value').first().text(),
            email: $('.lt-activation-info-value').eq(1).text(),
            name: $('.lt-activation-info-value').eq(2).text(),
            item_id: $('.lt-activation-info-value').eq(3).text(),
            export_timestamp: new Date().toISOString(),
            system_info: {
                user_agent: navigator.userAgent,
                language: navigator.language,
                platform: navigator.platform,
                cookie_enabled: navigator.cookieEnabled,
            }
        };
        
        // Create and download JSON file
        var dataStr = JSON.stringify(activationData, null, 2);
        var dataBlob = new Blob([dataStr], {type: 'application/json'});
        var url = URL.createObjectURL(dataBlob);
        
        var link = document.createElement('a');
        link.href = url;
        link.download = 'lt-activation-data-' + new Date().toISOString().split('T')[0] + '.json';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
        
        showNotice('Data exported successfully!', 'success');
    };

    function checkActivationStatus() {
        var themeHeader = document.querySelector('.ltx-theme-header');
        
        if (themeHeader) {
            $.ajax({
                url: ltActivation.ajaxurl,
                type: 'POST',
                data: {
                    action: 'lt_check_activation_status'
                },
                success: function(response) {
                    if (response.success && response.data.activated) {
                        themeHeader.classList.add('ltx-activated');
                        themeHeader.classList.remove('ltx-not-activated');
                    } else {
                        themeHeader.classList.add('ltx-not-activated');
                        themeHeader.classList.remove('ltx-activated');
                        addActivateButton();
                    }
                }
            });
        }
    }

    function addActivateButton() {
        var $h2 = $('.wrap h2');
        
        if ($h2.length) {
            var $container = $('<div style="text-align: center; margin: 10px 0 40px 0;"></div>');
            var $button = $('<a href="' + ajaxurl.replace('admin-ajax.php', 'admin.php?page=lt-activation') + '" class="button button-primary">Activate Theme</a>');
            $container.append($button);
            $h2.after($container);
        }
    }

    $(document).ready(function() {
        checkActivationStatus();
    });

})(jQuery);
