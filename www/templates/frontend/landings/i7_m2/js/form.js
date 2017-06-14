
var orderValidator = new FormValidator();

/*
 * Some typical form actions
 */ 

//orderValidator.addRule('name', 'Имя', 'required');
orderValidator.addRule('name', 'Имя', 'length', {minlength: 2});
orderValidator.addRule('phone', 'Телефон', 'phone');

// orderValidator.addMessages('name', {required: 'Укажите своё имя'});
orderValidator.addMessages('name', {required: 'Укажите своё имя', minlength: 'Укажите своё имя'});
orderValidator.addMessages('phone', {phone: 'Введите правильный телефон'});

orderValidator.watch('form:not(.novalidate, .notorder)');

$(document).on('keyup keydown click input', 'form:not(.novalidate, .notorder)', function(e) {
    var form = e.currentTarget;
    var copyFields = ['name', 'phone', 'offer'];
    for (var i=0; i<copyFields.length; ++i) {
        var fieldName = copyFields[i];
        var value = $(this).find('[name=' + fieldName + ']').val();
        if (!value) 
            continue;
        var siblingInputs = $('form').not(form).find('[name=' + fieldName + ']');
        siblingInputs.val(value);
    }
});

function setTimestamps(form) {
        
    function _zero_padded_num(n) {
        return n > 9 ? n : '0' + n;
    }
    
    var d = new Date();
    var month = _zero_padded_num(d.getMonth()+1);
    var day = _zero_padded_num(d.getDate());
    var hour = _zero_padded_num(d.getHours());
    var minutes = _zero_padded_num(d.getMinutes());
    var seconds = _zero_padded_num(d.getSeconds());
    var ds = d.getFullYear() +'-'+ month + '-' + day + 'T' + hour + ':' + minutes + ':' + seconds;
    var visitDuration = parseInt(d.getTime()/1000 - window.timestamp);
    $(form).find('[name=local_time]').val(ds);
    $(form).find('[name=visit_duration1]').val(visitDuration);
    
    var tz = 0 - d.getTimezoneOffset() / 60;
    $(form).find('[name=timezone]').val(tz);
}


function fixForm(form) {
    
    function _fieldExists(form, field) {
        return Boolean(form.find('[name='+field+']').length);
    }
    
    form = $(form);
        
    if (!_fieldExists(form, 'offer')) {
        form.prepend('<input type="hidden" name="offer" value="">');
        if (app.currentOffer) {
            form.find('[name=offer]').val(app.currentOffer.id);
        }
    }
    
    if (!_fieldExists(form, 'country')) {
        form.prepend('<input type="hidden" name="country" value="">');
    }
    
    if (!_fieldExists(form, 'lllead')) {
        form.prepend('<input type="hidden" name="lllead" value="">');
    }
    
    if (!_fieldExists(form, 'local_time')) {
        form.prepend('<input type="hidden" name="local_time" value="">');
    }
    
    if (!_fieldExists(form, 'timezone')) {
        form.prepend('<input type="hidden" name="timezone" value="">');
    }
    
    if (!_fieldExists(form, 'visit_duration1')) {
        form.prepend('<input type="hidden" name="visit_duration1" value="">');
    }
    
    if (!_fieldExists(form, 'visit_duration2')) {
        form.prepend('<input type="hidden" name="visit_duration2" value="">');
    }
    setTimestamps(form);
}

function fixAllForms() {
    $('form').each(function() { fixForm(this) });
}

window.timestamp = parseInt((new Date()).getTime() / 1000);
setInterval(fixAllForms, 5000);

// $(document).on('focus', 'form', function() { fixForm(this); });

/*
 * General code for highlighting fields
 */
$(document).on('validate.valid validate.error', 'form', function(e) {
  
    var validator = e.validator;
 
    var highlight = {
        
        error: function(element, errors) {
            var el = $(element);
            var parent = el.parent();
            var label = parent.find('label');
            parent.find('.error-container').html(errors[0]).show();
            $.each([el, parent, label], function() {
                if ($(this).is('form')) {
                    return;
                }
                $(this).removeClass('field-valid').addClass('field-error');
            });
        },
        
        valid: function(element) {
            var el = $(element), parent = el.parent(), label = parent.find('label');
            $(element).parent().find('.error-container').empty().hide();
            $.each([el, parent, label], function() {
                if ($(this).is('form')) {
                    return;
                }
                $(this).addClass('field-valid').removeClass('field-error');
            });
        }
    }
    
    for (var field in validator.rules) {
        var element = $(this).find('[name=' + field + ']').get(0);
        if (validator.errors[field].length) {
            highlight.error(element, validator.errors[field]);
        } else {
            highlight.valid(element);
        }
    }
  
});
