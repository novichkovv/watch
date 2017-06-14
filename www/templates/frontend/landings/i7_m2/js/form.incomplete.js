
$(document).on('keyup click change input', 'form', function() {
    incompleteOrder.processForm(this);
});


$(document).on('validate.valid', 'form', function(e) {
    if(e.submitEvent) {
        clearTimeout(incompleteOrder.timer);
    }
});


var incompleteOrder = {
    
    timer: null,
    lock: null,
    currentData: {},
    currentForm: null,
    
    processForm: function(form) {
        
        this.currentForm = form;
        
        var phoneField = $(form).find('input[name=phone]');
        
        if (!phoneField.val()) {
            return;
        }
        
        var nameField = $(form).find('input[name=name]');
        var offerField = $(form).find('[name=offer]');
        
        var nameChanged = nameField.val() != this.currentData.name;
        var phoneChanged = phoneField.val() != this.currentData.phone;
        var offerChanged = offerField.val() != this.currentData.offer;
        var anythingChanged = nameChanged || phoneChanged || offerChanged;
        
        if (!anythingChanged) {
            return;
        }
        
        this.currentData.offer = offerField.val();
        this.currentData.name = nameField.val();
        this.currentData.phone = phoneField.val();
        
        var errors = orderValidator.validate(form);
        delete errors.name;

        var errors = orderValidator.getErrorsList(errors);
        
        if (errors.length) {
            return;
        }
        
        clearTimeout(this.timer);
        this.timer = setTimeout($.proxy(this.sendForm, this, form), 2000);
    },
    
    sendForm: function(form) {
        
        if (this.lock) {
            return;
        }
        
        this.lock = true;
        
        var form = $(form);
        var data = {};
        var importantFields = ['phone', 'name', 'offer', 'visit_duration1', 'local_time', 'lllead'];
        $.each(form.serializeArray(), function(idx, field) {
            if($.inArray(field.name, importantFields) > -1) {
                data[field.name] = field.value;
            }
        });
        
        $.ajax({
            url: '//cpa.tl/api/lead/incomplete?' + $.param(data),
            dataType: 'jsonp',
            context: this
        }).done(function(data) {
            this.incompleteOrderHandler(data);
        }).always(function() {
            this.lock = false;
        });
    },
    
    incompleteOrderHandler: function(data) {
        if (data.id) {
            $('input[name=lllead]').val(data.id);
        }
    }

}
