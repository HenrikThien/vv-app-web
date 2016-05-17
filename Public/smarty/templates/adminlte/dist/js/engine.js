$( document ).ready(function() {
  $( "#loginForm" ).on( "submit", function( event ) {
    event.preventDefault();
    var dataToSend = $( this ).serializeArray();

    $.ajax({
      method: "POST",
      url: "http://app.visvitalis.info/Login/auth",
      data: dataToSend
    }).done(function( plain ) {
      if (plain.valid) {
        setMessage(true, "success", plain.message);

        setTimeout(function() {
          window.location.href = "http://app.visvitalis.info/Home/";
        }, 2000);
      } else {
        setMessage(true, "danger", plain.message);
      }
    });
  });

  $("#enterNewMaskForm").on("submit", function(event) {
    event.preventDefault();
    var dataToSend = $(this).serializeArray();
    var groupid = $("#placeHolderHeading").attr("loaded-group");
    dataToSend.push({name: 'maskid', value: $("#placeHolderHeading").attr("loaded-id")});
    dataToSend.push({name: 'groupid', value: groupid});

    $.ajax({
      method: "POST",
      url: "http://app.visvitalis.info/CreateMask/createnew",
      data: dataToSend
    }).done(function(plain) {
      if (plain.valid) {
        setMessage(true, "success", plain.message);
        $("#inputPatNr").val("");
        $("#inputPatFirstname").val("");
        $("#inputPatLastname").val("");
        $("#inputMission").val("");
        $("#inputPerformances").val("");

        addMaskPatientToTable("#masksPatientsTable", plain.pat_data);
        loadOldMasks(groupid);

        $("#masksPatientsTable").tableDnD({
            onDragClass: "myDragClass",
            onDrop: function(table, row) {
                var rows = table.tBodies[0].rows;
                var data = [];
                var order = [];

                for (var i=0; i<rows.length; i++) {
                    var obj = new Object();
                    obj.order = i;
                    obj.patient = rows[i].id.substr(8, rows[i].id.length);
                    order.push(obj);
                }

                data.push({name: 'maskid', value: $("#placeHolderHeading").attr("loaded-id")});
                data.push(order);

                $.ajax({
                    method: "POST",
                    data: { data: data },
                    url: "http://app.visvitalis.info/CreateMask/changeposition/"
                }).done(function(plain) {

                });
            },
            onDragStart: function(table, row) {
            }
        });
      }
      else {
        setMessage(true, "danger", plain.message);
      }
    });
  });

  $( "#emailForm" ).on( "submit", function( event ) {
        event.preventDefault();
        var dataToSend = $( this ).serializeArray();
        $.ajax({
            method: "POST",
            url: "http://app.visvitalis.info/Home/SaveSettings/email/",
            data: dataToSend
        }).done(function( plain ) {
            if (plain.valid) {
                setMessage(true, "success", plain.message);
            } else {
                setMessage(true, "danger", plain.message);
            }
        });
  });

  $( "#passwordForm" ).on( "submit", function( event ) {
        event.preventDefault();
        var dataToSend = $( this ).serializeArray();
        $.ajax({
            method: "POST",
            url: "http://app.visvitalis.info/Home/SaveSettings/password/",
            data: dataToSend
        }).done(function( plain ) {
            if (plain.valid) {
                setMessage(true, "success", plain.message);
            } else {
                setMessage(true, "danger", plain.message);
            }
        });
  });

  $("#masksPatientsTable").on("click", ".deletePat", function(event) {
    event.preventDefault();
    var patNr = $(this).attr("patnr");
    var theid = $(this).attr("theid");
    var patmis = $(this).attr("patmis");

    var groupid = $("#placeHolderHeading").attr("loaded-group");
    var masknr = $("#placeHolderHeading").attr("loaded-id");

    var data = "patnr=" + patNr + "&masknr=" + masknr + "&theid=" + theid + "&patmis=" + patmis;

    $.ajax({
      method: "POST",
      url: "http://app.visvitalis.info/CreateMask/removepatient",
      data: data
    }).done(function(plain) {
      if (plain.valid) {
        $("#masksPatientsTable tr#patient-" + theid).remove();
        setMessage(true, "success", plain.message);
        loadOldMasks(groupid);
      }
      else {
        setMessage(true, "danger", plain.message);
      }
    });
  });

  $("#week_select").on('change', function() {
    var id = this.value;

    $("#exportWeekBtn").addClass("disabled");
    $("#patientTable tbody > tr").remove();

    if (id == -1) {
      return;
    }

    $.ajax({
      method: "POST",
      url: "http://app.visvitalis.info/FinishedMasks/getpatientsforweek",
      data: "mask_id=" + id
    }).done(function( plain ) {
      if (plain.valid) {
        setMessage(true, "success", plain.message);
        $("#exportWeekBtn").removeClass("disabled");
        $.each(plain.patients, function(k,v) {
           addPatientToFinishedTable("#patientTable", plain.patients[k]);
        });
      } else {
        setMessage(true, "danger", plain.message);
      }
    });
  });

  $("#exportWeekBtn").on("click", function(event) {

  });

  $('#deviceSelection').change(function(event){
      event.preventDefault();
      var value = $(this).find("option:selected").attr('value');
      var rowOne = $("#rowOne");
      var rowTwo = $("#rowTwo");

      $("#existingMasks").empty();
      rowTwo.addClass("hidden");
      $("#addBtn").addClass("disabled");

      $("#placeHolderHeading").attr("loaded-id", "-1");
      $("#placeHolderHeading").attr("loaded-group", "");

      if (value == -1) {
          rowOne.addClass("hidden");
      } else {
          rowOne.removeClass("hidden");
          $("#placeHolderHeading").attr("loaded-group", value);
          loadOldMasks(value);
      }
  });

  $("#newMask").on("click", function(event) {
      event.preventDefault();
      var value = $("#deviceSelection").find("option:selected").attr('value');
      $.ajax({
         method: "GET",
         url: "http://app.visvitalis.info/CreateMask/createnewmask/" + value
      }).done(function(plain) {
          loadOldMasks(value);
      });
  });


  $("#existingMasks").on("click", ".loadMaskBtn", function(event) {
    event.preventDefault();
    var group = $("#deviceSelection").find("option:selected").html();
    var groupid = $(this).parent().attr("groupid");
    var maskid = $(this).parent().attr("maskid");
    var data = "gid=" + groupid + "&mid=" + maskid;

    $.ajax({
       method: "POST",
       data: data,
       url: "http://app.visvitalis.info/CreateMask/getpatients/"
    }).done(function(plain) {
        $("#rowTwo").removeClass("hidden");
        $("#masksPatientsTable tbody").empty();
        $("#placeHolderHeading").text("Maske für die Gruppe " + group);
        $("#addBtn").removeClass("disabled");
        $("#placeHolderHeading").attr("loaded-id", maskid);
        $.each(plain, function(k,v) {
           addMaskPatientToTable("#masksPatientsTable", plain[k]);
        });
        $("#masksPatientsTable").tableDnD({
            onDragClass: "myDragClass",
            onDrop: function(table, row) {
                var rows = table.tBodies[0].rows;
                var data = [];
                var order = [];
                for (var i=0; i<rows.length; i++) {
                    var obj = new Object();
                    obj.order = i;
                    obj.patient = rows[i].id.substr(8, rows[i].id.length);
                    order.push(obj);
                }

                data.push({name: 'maskid', value: maskid });
                data.push(order);

                $.ajax({
                    method: "POST",
                    data: { data: data },
                    url: "http://app.visvitalis.info/CreateMask/changeposition/"
                }).done(function(plain) {

                });
            },
            onDragStart: function(table, row) {
            }
        });
    });
  });

  $("#existingMasks").on("click", ".deleteMaskBtn", function(event) {
     event.preventDefault();
     var groupid = $(this).parent().attr("groupid");
     var maskid = $(this).parent().attr("maskid");
     var data = "gid=" + groupid + "&mid=" + maskid;

     $.ajax({
       method: "POST",
       data: data,
       url: "http://app.visvitalis.info/CreateMask/deletemask/"
    }).done(function(plain) {
        loadOldMasks(groupid);
        var rowOne = $("#rowOne");
        var rowTwo = $("#rowTwo");
        rowTwo.addClass("hidden");
        $("#addBtn").addClass("disabled");
        setMessage(true, "success", "Die Maske wurde erfolgreich gelöscht!");
    });
  });

  $("#existingMasks").on("click", ".setFavo", function(event) {
     event.preventDefault();
     var groupid = $(this).parent().attr("groupid");
     var maskid = $(this).parent().attr("maskid");

     var type = '0';

     $('#existingMasks').find('*').each(function(){
        if ($(this).hasClass("glyphicon glyphicon-star")) {
            $(this).removeClass("glyphicon glyphicon-star");
            $(this).addClass("glyphicon glyphicon-star-empty");
        }
    });
     if ($(this).hasClass("glyphicon glyphicon-star-empty")) {
         $(this).removeClass("glyphicon glyphicon-star-empty");
         $(this).addClass("glyphicon glyphicon-star");
         type = '1';
     }
     else if ($(this).hasClass("glyphicon glyphicon-star")) {
         $(this).removeClass("glyphicon glyphicon-star");
         $(this).addClass("glyphicon glyphicon-star-empty");
         type = '0';
     }
     var data = "gid=" + groupid + "&mid=" + maskid;

     $.ajax({
        method: "POST",
        url: "http://app.visvitalis.info/CreateMask/setfavorite/" + type,
        data: data
     }).done(function(plain) {
         //...
     });
  });


  $("#inputGroupNew").change(function(event){
      event.preventDefault();
      var value = $(this).find("option:selected").attr('value');

      if (value != -1) {
          $("#startDateRange").removeClass("hidden");
          $("#endDateRange").removeClass("hidden");
          $("#btnStartSearchDiv").removeClass("hidden");
      } else {
          $("#startDateRange").addClass("hidden");
          $("#endDateRange").addClass("hidden");
          $("#btnStartSearchDiv").addClass("hidden");
      }
  });

  $("#inputGroup").change(function(event){
      event.preventDefault();
      var value = $(this).find("option:selected").attr('value');

      if (value == -1) {
          $("#maskOptions").addClass("hidden");
      } else {
          $("#maskOptions").removeClass("hidden");
          $.ajax({
              method: "POST",
              url: "http://app.visvitalis.info/FinishedMasks/searchget",
              data: {groupid: value}
          }).done(function(plain) {
              if (plain.valid) {
                  var html = '';
                  $.each(plain.patients, function(idx, v) {
                      console.log(v.id);
                      html += '<option value="' + v.id + '">[#' + v.id + '] ' + v.datum_start + ' - ' + v.datum_end + '</option>';
                  });
                  $("#inputMaskRange").append(html);
              }
          });
      }
  });

  $("#searchQueryForm").on("submit", function(event) {
     event.preventDefault();
     $("#patientTable tbody").empty();
     var box = $("#exportArea");
     box.removeClass("hidden");
     $("#exportArea div.overlay").removeClass("hidden");

     var data = $(this).serializeArray();

     $.ajax({
         method: "POST",
         url: "http://app.visvitalis.info/ExportMasks/getpatients",
         data: data
     }).done(function(plain) {
         if (plain.valid) {
                 $.each(plain.patients, function(idx, v) {
                    addPatientToFinishedTable("#patientTable", v);
                 });
                 $("#exportArea div.overlay").addClass("hidden");
             } else {
                 setMessage(true, "danger", "Fehler bei der Verarbeitung.");
             }
     });
  });

  $("#inputMaskRange").change(function(event) {
     event.preventDefault();
     var value = $(this).find("option:selected").attr("value");
     var box = $("#exportArea");
     box.removeClass("hidden");
     $("#exportArea div.overlay").removeClass("hidden");

     if (value == -1) {
         $("#exportWeekBtn").addClass("disabled");
         $("#patientTable tbody").empty();
         box.addClass("hidden");
     } else {
         $("#exportWeekBtn").removeClass("disabled");
         $("#patientTable tbody").empty();

         $.ajax({
           method: "POST",
           url: "http://app.visvitalis.info/FinishedMasks/getpatients/",
           data: {id: value}
         }).done(function(plain) {
             if (plain.valid) {
                 $.each(plain.patients, function(idx, v) {
                    addPatientToFinishedTable("#patientTable", v);
                 });
                 $("#exportArea div.overlay").addClass("hidden");
             } else {
                 setMessage(true, "danger", "Fehler bei der Verarbeitung.");
             }
         });
     }
  });

  $("#copyMaskForm").on( "submit", function( event ) {
      event.preventDefault();
      var loadingBtn = $("#copyMaskSubmitBtn");
      loadingBtn.button('loading');
      var dataToSend = $(this).serializeArray();
      var deviceid = $("#placeHolderHeading").attr("loaded-group");

      dataToSend.push({name: 'cgroup', value: deviceid});

      $.ajax({
        method: "POST",
        url: "http://app.visvitalis.info/CreateMask/copymask",
        data: dataToSend
      }).done(function (plain) {
        loadingBtn.button('reset');
        $("#copyMaskModal").modal('hide');

        if (plain.valid) {
          setMessage(true, "success", "Die Maske wurde erfoglreich kopiert und kann benutzt werden.");
        } else {
          setMessage(true, "danger", plain.message);
        }
      });
  });

  $("#sendToDeviceBtn").on("click", function(event) {
    event.preventDefault();
    var btn = $(this).button('loading');
    var deviceid = $("#placeHolderHeading").attr("loaded-group");
    var maskid = $("#placeHolderHeading").attr("loaded-id");

    var data = "device_id=" + deviceid + "&mask_id=" + maskid;

    $.ajax({
      method: "POST",
      url: "http://app.visvitalis.info/CreateMask/sendtodevice",
      data: data
    }).done(function(plain) {
      btn.button('reset');
      if (plain.success > 0) {
        setMessage(true, "success", "Die Nachricht wurde erfolgreich an das Gerät verschickt!");
        //$("#masksPatientsTable tbody > tr").remove();
      }
      else {
        setMessage(true, "danger", ((!plain.message) ? plain.message : "Fehler beim Versenden."));
      }
    });
  });
});

function loadOldMasks(value) {
    $("#existingMasks").empty();
    $.ajax({
        method: "GET",
        url: "http://app.visvitalis.info/CreateMask/getoldmasks/" + value
    }).done(function(plain) {
        $.each(plain, function(k,v) {
            var favo = "glyphicon glyphicon-star-empty";
            if (v.favo == "1") {
                favo = "glyphicon glyphicon-star";
            }

            $("#existingMasks").append("<li class=\"list-group-item\"><span class=\"badge \">" + v.pcount + "</span> Maske Nr. " + v.id + " <a groupid=\"" + value + "\" maskid=\"" + v.id + "\" href=\"javascript:void(0)\"><span style=\"margin-right:7px;\" class=\"deleteMaskBtn pull-right glyphicon glyphicon-trash\"></span></a> <a groupid=\"" + value + "\" maskid=\"" + v.id + "\" href=\"javascript:void(0)\"><span style=\"margin-right:7px;\" class=\"loadMaskBtn pull-right glyphicon glyphicon-download-alt\"></span></a><a groupid=\"" + value + "\" maskid=\"" + v.id + "\" href=\"javascript:void(0)\"><span style=\"margin-right:7px;\" class=\"setFavo pull-right " + favo + "\"></span></a></li>")
        });
    });
};
function addMaskPatientToTable(table,data) {
  $(table + " tbody").append("<tr id='patient-" + data.id + "'><td>" + data.pat_nr + "</td><td>" + data.pat_firstname + "</td><td>" + data.pat_lastname + "</td><td>" + data.pat_mission + "</td><td>" + data.pat_performances + "</td><td><a href='javascript:void(0)' class='deletePat' theid='" + data.id + "' patmis='" + data.pat_mission + "' patnr='" + data.pat_nr + "' masknr='" + data.masknr + "'><span class='glyphicon glyphicon-trash'></span></a></td><td><a class='orderUp' pat-id='" + data.pat_nr + "' href='javascript:void(0)'<span class='glyphicon glyphicon-arrow-up'></span></a><a pat-id='" + data.pat_nr + "' class='orderDown' style='margin-left: 5px' href='javascript:void(0)'<span class='glyphicon glyphicon-arrow-down'></span></a></td></tr>")
};
function addPatientToFinishedTable(table,data) {
  var state = (data.pat_performances == "xx") ? "warning" : "success";
  state = (data.pat_nr == 1 || data.pat_nr == 2) ? "info" : state;
  
  var arrival = getFormattedDate(data.pat_arrival);
  var departure = getFormattedDate(data.pat_departure);
  $(table + " tbody").append("<tr class='" + state + "'><td>D</td><td>" + data.date + "</td><td>M</td><td>" + data.worker_token + "</td><td>K</td><td>" + data.pat_km + "</td><td>P</td><td>" + data.pat_nr + "</td><td>E</td><td>" + data.pat_mission + "</td><td>Z</td><td>" + arrival + "</td><td>" + departure + "</td><td>L</td><td>" + data.pat_performances + "</td></tr>");
};
function getFormattedDate(oldDate) {
    if (oldDate == "00:01" || oldDate == "00:02") {
        return oldDate;
    }

    var coeff = 1000 * 60 * 5;
    var date = new Date("January 01, 1975 " + oldDate + ":00");
    var roundedArrival = new Date(Math.round(date.getTime() / coeff) * coeff);

    var h = roundedArrival.getHours();
    var m = roundedArrival.getMinutes();

    if (h < 10) h = '0' + h;
    if (m < 10) m = '0' + m;

    return h + ':' + m;
};
function setMessage(show,type,message) {
  if (show)
    $("#messageBox").removeClass("hidden");
  else
    $("#messageBox").addClass("hidden");

  // hardcoded todo
  $("#messageBox").removeClass("alert-success").removeClass("alert-danger").removeClass("alert-info").removeClass("alert-primary").removeClass("alert-warning");
  $("#messageBox").addClass("alert-" + type);
  $("#messageBox").addClass("alert-dismissible");
  $("#messageBox").html("<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + message);
};
