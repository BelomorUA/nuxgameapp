@extends('layouts.app')

@section('content')
    <div class="link-container">
        <p id="response"></p>
        <input type="hidden" value="{{ $user->unique_link }}" id="unique_link">
        <p>Your unique link: <p  class="link" id="user">{{ $user->unique_link }}</p>
        <p class="link" id="generate_new_link">Generate New Link</p>
        <p  class="link" id="deactivate_link">Deactivate Link</p>
        <p><button id="im_feeling_lucky">I'm Feeling Lucky</button></p>
        <p><button id="history">History</button></p>
        <div id="history_container">
            <table cellspacing="0">
                <tr>
                    <td>Random number</td>
                    <td>Win amount</td>
                    <td>Result</td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        let history = true;
        $('#user').on('click', function() {
            let unique_link = $('#unique_link').val();
            console.log(unique_link);
            window.location.replace("/user/"+unique_link);
        });
        $('#generate_new_link').on('click', function() {
            let unique_link = $('#unique_link').val();
            $.ajax({
                url: `/user/`+unique_link+`/generate`,
                method: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    $('#response').html(`New link generated`);
                    $('#user').html(`${response.unique_link}`);
                    $('#unique_link').val(`${response.unique_link}`);
                },
                error: function() {
                    $('#response').html('Failed to generate new link.');
                }
            });
        });

        $('#deactivate_link').on('click', function() {
            let unique_link = $('#unique_link').val();
            $.ajax({
                url: `/user/`+unique_link+`/deactivate`,
                method: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    $('#response').html(`Link deactivated`);
                },
                error: function() {
                    $('#response').html('Failed to deactivate new link.');
                }
            });
        });

        $('#im_feeling_lucky').on('click', function() {
            let unique_link = $('#unique_link').val();
            $.ajax({
                url: `/user/`+unique_link+`/feeling-lucky`,
                method: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    console.log(response);
                    if(response.winAmount > 0){
                        $('#response').html(`You win: `+response.winAmount);
                    } else {
                        $('#response').html(`Today is not your day`);
                    }

                },
                error: function() {
                    $('#response').html('Failed to try luck.');

                }
            });
        });

        $('#history').on('click', function() {
            if(!history){
                $('#response').html(`History already loaded`);
                return;
            }
            let unique_link = $('#unique_link').val();
            let table = '';
            $.ajax({
                url: `/user/`+unique_link+`/history`,
                method: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    console.log(response);

                    $.each(response.result, function(index, value) {
                        console.log(value);
                        table += '<tr><td>'+value.random_number+'</td><td>'+value.win_amount+'</td><td>'+value.result+'</td></tr>';
                    });
                    $('#history_container table').append(table);
                    $('#history_container').slideDown();
                    $('#response').html(`History loaded`);
                    history = false;
                },
                error: function() {
                    $('#response').html('Failed to load history.');
                }
            });
        });
    </script>
@endsection
