<style>
    table, td, th {  
      border: 1px solid #ddd;
      text-align: center;
      text-size-adjust: inherit;
    }
    
    table {
      border-collapse: collapse;
      width: 100%;
    }
    
    th, td {
      padding: 1px;
      height: 35px;   
     }
    </style>
<div lass="table-responsive-sm">
        <!-- Interact with the `state` property in Alpine.js -->
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">
                        Fecha
                    </th>
                    <th scope="col">
                        Hora de inicio
                    </th>
                    <th scope="col">
                        Hora de fin
                    </th>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>
                        {{$item->schedule_date}}
                    </td>
                    <td>
                        {{$item->start_time}}
                    </td>
                    <td>
                        {{$item->end_time}}
                    </td>
                </tr>    
        @endforeach
            </tbody>
        </table>
</div>
