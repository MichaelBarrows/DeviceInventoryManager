<!DOCTYPE html>
<html>
    <head>
        <title>Users</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            // Retrieve the users data from the API
            $.ajax({
              url: "http://localhost:8000/api/users",
              type: 'GET',
              success: function(data) {
                $.each(data, function(index, item) {
                  var user = item;
                  var app = $('#app');
                  // Create the container to hold the users data
                  var container = document.createElement('div');
                  container.setAttribute('id', 'user-'+item.id);
                  container.setAttribute('class', 'user-container');
                  // Users data elements
                  var name = document.createElement('p');
                  name.setAttribute('id', item.id);
                  name.innerHTML = item.name;
                  container.append(name);
                  var email = document.createElement('p');
                  email.innerHTML = item.email;
                  container.append(email);
                  // Link to trigger API call for active devices
                  var link = document.createElement('a');
                  link.setAttribute('href', '#');
                  link.setAttribute('id', item.id);
                  link.innerHTML = "Active Devices";
                  link.onclick = function() {
                    event.preventDefault();
                    // Get devices data from the API
                    $.ajax({
                      url: "http://localhost:8000/api/users/"+this.id+"/devices/active",
                      type: 'GET',
                      success: function (data) {
                        // Function to process the data from the API
                        device_success(user.id, data);
                      },
                      error: function(){
                        var data = {'active_devices': ''}
                        device_success(user.id, data);
                      }
                    })
                  }
                  container.append(link);
                  // Container to hold the devices
                  var devices = document.createElement('div');
                  devices.setAttribute('class', 'devices');
                  container.append(devices);
                  app.append(container);
                });
              }
            });

            // Function to process the devices data returned from the API
            function device_success(user_id, data) {
              var user_container = $('#user-'+user_id).children('.devices');
              // Empty the container so that the data isn't repeated if the link is clicked again
              user_container.empty();
              if (data.active_devices.length > 0) {
                // Loop over the devices
                $.each(data.active_devices, function(index, item) {
                  var device = item;
                  // Single device container
                  var device_container = document.createElement('div');
                  device_container.setAttribute('id', 'device-'+item.id);
                  device_container.setAttribute('class', 'device_container');
                  device_container.remove();
                  var device_man_model = document.createElement('p');
                  device_man_model.innerHTML = "Device: "+ item.device_model.manufacturer.name + " " + item.device_model.name + " ("+item.device_model.device_type.type+")";
                  device_container.append(device_man_model);
                  var os = document.createElement('p');
                  os.innerHTML = "OS: "+ item.device_model.operating_system.name;
                  device_container.append(os);
                  var imei = document.createElement('p');
                  imei.innerHTML = "IMEI: "+item.imei;
                  device_container.append(imei);
                  var serial_number = document.createElement('p');
                  serial_number.innerHTML = "Serial Number: "+item.serial_number;
                  device_container.append(serial_number);
                  var assignment_start = document.createElement('p');
                  assignment_start.innerHTML = "Assignment Start: "+item.pivot.assignment_start;
                  device_container.append(assignment_start);
                  // Assignment_end is either the date assignment is terminated
                  // or the status if active
                  var assignment_end = document.createElement('p');
                  if (item.pivot.assignment_end != null){
                    assignment_end.innerHTML = "Assignment End: "+item.pivot.assignment_end;
                  } else {
                    assignment_end.innerHTML = "Current Device: True";
                  }
                  device_container.append(assignment_end);
                  // Link to get sim and phone number data
                  var sim_details = document.createElement('a');
                  sim_details.setAttribute('href', '#');
                  sim_details.setAttribute('id', item.id);
                  sim_details.innerHTML = "Sim &amp; Number Details<br />";
                  sim_details.onclick = function() {
                    event.preventDefault();
                    // Function to get active sim cards
                    $.ajax({
                      url: "http://localhost:8000/api/devices/"+this.id+"/sim-cards/active",
                      type: 'GET',
                      success: function (data) {
                        // Function call to handle response
                        sim_card_success(device.id, data);
                      },
                      error: function(){
                        var data = {'active_sim_cards': ''}
                        sim_card_success(device.id, data);
                      }
                    })
                  }
                  device_container.append(sim_details);
                  user_container.append(device_container);
                });
              } else {
                // No devices exist - a message is displayed to this effect
                var nodevices = document.createElement('p');
                nodevices.innerHTML = '<strong>NO CURRENT DEVICES</strong>';
                user_container.append(nodevices);
              }
            }

            // Function to handle sim card data
            function sim_card_success(device_id, data) {
              // Individual device data container
              var device_container = $('#device-'+device_id);
              // Checks that at least one record was returned
              if (data.active_sim_cards.length > 0) {
                // Loops over active sim cards
                $.each(data.active_sim_cards, function(index, item) {
                  var sim_card = item;
                  var sim_number = document.createElement('p');
                  sim_number.innerHTML = "Sim Number: "+item.sim_number;
                  device_container.append(sim_number);
                  var network_provider = document.createElement('p');
                  network_provider.innerHTML = "Network Provider: "+item.network_provider.provider;
                  device_container.append(network_provider);
                  // Either date of termination or current status
                  var assignment_end = document.createElement('p');
                  if (item.pivot.assignment_end != null){
                    assignment_end.innerHTML = "Assignment End: "+item.pivot.assignment_end;
                  } else {
                    assignment_end.innerHTML = "Current Sim Card: True";
                  }
                  device_container.append(assignment_end);
                  // API call to get phone numbers
                  $.ajax({
                    url: "http://localhost:8000/api/sim-cards/"+sim_card.id+"/phone-numbers/active",
                    type: 'GET',
                    // Phone numbers data processing
                    success: function (data) {
                      $.each(data.active_phone_numbers, function(index, item) {
                        var phone_number = document.createElement('p');
                        phone_number.innerHTML = "Phone Number: "+item.phone_number;
                        device_container.append(phone_number);
                        var network_provider = document.createElement('p');
                        network_provider.innerHTML = "Network Provider: "+item.network_provider.provider;
                        device_container.append(network_provider);
                        var assignment_end = document.createElement('p');
                        if (item.pivot.assignment_end != null){
                          assignment_end.innerHTML = "Assignment End: "+item.pivot.assignment_end;
                        } else {
                          assignment_end.innerHTML = "Current Phone Number: True";
                        }
                        device_container.append(assignment_end);
                      });
                    },
                    error: function(){
                      return false;
                    }
                  });
                });
              }
            }
        </script>
        <style>
            /* Basic styling for the page */
            p {
              margin: 5px;
            }
            .user-container {
              border-bottom: 2px solid #000;
              padding: 5px;
            }
            .user-container a:link, .user-container a:visited {
              color: #0099cc;
              font-size: 1.25em;
            }
            .device_container {
              border: #000 2px solid;
              /* color: #FFF; */
              padding: 5px;
              margin: 5px 0;
            }
            .device_container p {
              display: inline-block;
              width: 30vw;
            }
        </style>
    </head>
    <body>
        <!-- Container which all elements are appended to -->
        <div id="app"></div>
    </body>
</html>
