<x-layout>
    <x-card>
        <x-form :model="$model" :upload="true">
            <x-action form="form">
                @if($model)
                <x-button :module="'getJenis'" :key="$model->field_primary" color="success" label="Update Jenis" />
                @endif
                </x-action>

            @bind($model)

            <x-form-input col="6" name="rs_code" />
            <x-form-input col="6" name="rs_nama" />
            <x-form-select col="6" name="rs_status" :options="$status" />
            <x-form-upload col="3" name="logo" />
             <div class="col-md-3">
                <img class="img-thumbnail img-fluid" src="{{ url('storage/logo/'.$model->field_logo) ?? url('noimage.jpeg') }}" alt="logo">
            </div>
            <x-form-textarea col="12 form-group" name="rs_alamat" />

            @level(UserLevel::Finance)
            <x-form-input type="number" col="6" name="rs_harga_cuci" />
            <x-form-input type="number" col="6" name="rs_harga_sewa" label="Rental"/>
            @endlevel

            <x-form-select col="6" class="tag" :default="$selected_ruangan ?? []" name="ruangan[]" multiple :options="$ruangan" />
            <x-form-select col="6" class="tag" :default="$selected_jenis ?? []" name="jenis[]" multiple :options="$jenis" />
            @endbind

        </x-form>
    </x-card>
</x-layout>
