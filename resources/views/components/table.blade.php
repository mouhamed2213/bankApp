<div class="overflow-x-auto">
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    <table  class="w-full  text-center text-black-500" >
        <thead>
            <tr>
                <th>{{ $MyTablehead }}</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td> {{ $slot }} </td>
            </tr>
        </tbody>
    </table>
\</div>
