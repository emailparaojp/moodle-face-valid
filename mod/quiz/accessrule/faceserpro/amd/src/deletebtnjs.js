define(['jquery', 'core/ajax', 'core/notification'],
    function() {
    return {
        setup: function(props) {
            var pathName = window.location.href;
            if (pathName.includes("/admin/settings.php?section=modsettingsquizcatfaceserpro")) {
                const div = document.createElement('div');
                div.id = 'deletebtndiv';
                div.className = 'row';
                div.style.marginTop = '10px';

                const labelcontainer = document.createElement('div');
                labelcontainer.className = 'form-label col-sm-3 text-sm-right';

                const deleteALLLabel = document.createTextNode(props.formlabel);
                labelcontainer.appendChild(deleteALLLabel);

                const btnContainer = document.createElement('div');
                btnContainer.className = 'form-label col-sm-3 text-sm-left';

                const confirmmsg = props.deleteconfirm;

                const confirmIt = function(e) {
                    /*eslint no-alert: "error"*/
                    if (!confirm(confirmmsg)) {
                        e.preventDefault();
                    }
                };

                const btntag = document.createElement("a");
                const text = document.createTextNode(props.btnlabel);
                btntag.className = 'btn btn-warning';
                btntag.href = props.pageurl;
                btntag.appendChild(text);
                btntag.addEventListener('click', confirmIt, false);


                btnContainer.appendChild(btntag);
                div.appendChild(labelcontainer);
                div.appendChild(btnContainer);
                const adminforms = document.getElementsByClassName("settingsform");
                if (adminforms.length > 0) {
                    adminforms[0].appendChild(div);
                }
            }

            if ($('#id_s_quizaccess_faceserpro_fcmethod :selected').text() == "None") {
                $('#id_s_quizaccess_faceserpro_fcheckstartchk').prop('checked', false);
                $('#id_s_quizaccess_faceserpro_fcheckstartchk').prop('disabled', true);
            }

            $('#id_s_quizaccess_faceserpro_fcmethod').click(function () {
                if ($('#id_s_quizaccess_faceserpro_fcmethod :selected').text() == "None") {
                    $('#id_s_quizaccess_faceserpro_fcheckstartchk').prop('checked', false);
                    $('#id_s_quizaccess_faceserpro_fcheckstartchk').prop('disabled', true);
                } else {
                    $('#id_s_quizaccess_faceserpro_fcheckstartchk').prop('disabled', false);
                }
            });

            return true;
        }
    };
});
