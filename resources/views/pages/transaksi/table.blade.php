<x-layout>

    <x-card>

        <x-form method="GET" action="{{ moduleRoute('getTable') }}">
            <x-filter toggle="Filter" :fields="$fields" />
        </x-form>

        <x-form method="POST" action="{{ moduleRoute('getTable') }}">

            <div class="container-fluid">
                <div class="table-responsive" id="table_data">
                    <table class="table table-bordered table-striped overflow">
                        <thead>
                            <tr>
                                <th class="text-center column-action">{{ __('Action') }}</th>
                                <th class="text-center column-checkbox">{{ __('No.') }}</th>
                                @foreach($fields as $value)
                                    <th {{ Template::extractColumn($value) }}>
                                        @if($value->sort)
                                            @sortablelink($value->code, __($value->name))
                                            @else
                                                {{ __($value->name) }}
                                            @endif
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $table)
                                <tr>
                                    <td class="col-md-2 text-center column-action">
                                        <div class="">
                                            <x-button module="getUpdate" key="{{ $table->field_primary }}" color="primary"
                                                icon="document-edit" label="Detail" />
                                        </div>
                                    </td>
                                    <td>{{ iteration($data, $key) }}</td>
                                    <td>{{ $table->field_status_transaction }}</td>
                                    <td>{{ $table->field_key }}</td>
                                    <td>{{ $table->field_total }}</td>
                                    <td>{{ $table->field_rs_name }}</td>
                                    <td>{{ formatDate($table->field_created_at) }}</td>
                                    <td>{{ $table->field_created_name }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <x-pagination :data="$data" />
            </div>

        </x-form>

    </x-card>

</x-layout>