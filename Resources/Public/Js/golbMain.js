(function($) {
    'use strict';

    $(document).ready(function() {
        var doc = $(document),
            epkPh = doc.find('.extpk_placeholder'),
            epkInputArea = doc.find('.extpk_suggest'),
            addInput = epkInputArea.find('input:first'),
            addBtn = epkInputArea.find('.extpk_add'),
            kwArea = doc.find('.extpk_keywords'),
            keyword = kwArea.find('.keyword'),
            hiddenField = kwArea.find('.extpk_hidden');

        addInput.autocomplete({
            source: GOLBavailableTags
        });

/*
        $.get('ajax.php', {
            ajaxID: 'Golb::golb_tags',
            L: $('.extpk_language').val()
        }, function(response){
            console.log('tt');
            var epkKW = $.parseJSON(response);
            if (epkKW.status === 'error') {
                alert('Error while changing sorting. Please refresh page and try again.');
            } else {
                var availableTags = $.parseJSON(epkKW.title);

                addInput.autocomplete({
                    source: availableTags
                });
            }
        });
*/
        addInput.on('keydown', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 9) {
                e.preventDefault();
                addKeyword(addInput.val());
                return false;
            } else if (keyCode == 13) {
                e.preventDefault();
                addKeyword(addInput.val());
                return false;
            }
        });

        kwArea.on('click', '.extpk_close' , function(e) {
            e.preventDefault();
            removeKeyword( $(this) );
        });
        addBtn.on('click', function(e) {
            e.preventDefault();
            addKeyword(addInput.val());
        });

        /**
         * Add Keywords to the bubbles and to the hidden keyword-inputfield
         * @param value
         */
        function addKeyword(value) {
            addInput.autocomplete("close");

            if ( checkDuplication(value) && value.trim() != '') {
                var item = $('<label class="keyword">' +
                '<span class="value">' + value + '</span><span class="extpk_close">x</span>' +
                '<input class="extpk_hidden" type="hidden" autocomplete="off" value="'+ value +'" name="data['+ GOLBTable +']['+ GOLBId +'][golb_tags_hidden][]"/></label>').hide().fadeIn(500);

               kwArea.append(item);

                /*
                if ( hiddenField.val() == '') {

                    hiddenField.val(value);
                } else {

                    var newDiv= document.createElement('input');
                    newDiv.setAttribute('class','extpk_hidden');
                    newDiv.setAttribute('type','hidden');
                    newDiv.setAttribute('autocomplete','off');
                    newDiv.setAttribute('value',value);
                    newDiv.setAttribute('name', 'data[' + GOLBTable + ']['+ GOLBId +'][golb_tags_hidden][]')
                    document.body.appendChild(newDiv);
                    console.log(newDiv)
                    //hiddenField.val( hiddenField.val() + ',' + value);
                }
*/
            }
            addInput.val('');
        }

        /**
         * Removes the items from the hidden fields
         * @param obj
         */
        function removeKeyword(obj) {
            if(hiddenField .length > 0){
            var removeItem = obj.parent();
            removeItem.remove();

            obj.parent().fadeOut();

            }
        }

        /**
         * Checks if the values is already set within the hidden field
         * @param checkValue
         */
        function checkDuplication(checkValue) {
            if(hiddenField.length > 0) {
                var hiddenValues = hiddenField.val().split(','),
                    checkValue = checkValue.toLowerCase().trim(),
                    rstl = true;

               //  console.debug(checkValue);

                $.each(hiddenValues, function (index, value) {
                    value = $.trim(value.toLowerCase());
                    if (value === checkValue) {
                        rstl = false;
                    }
                });
                return rstl;
            }
            return true;
        }


    });

}(TYPO3.jQuery));
