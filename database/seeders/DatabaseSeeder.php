<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(MHCatalogoGeneral::class);
        $this->call(MHAmbienteDestino::class);
        $this->call(MHTipoDocumento::class);

        $this->call(MHModeloFacturacion::class);
        $this->call(MHTipoTransmision::class);
        $this->call(MHTipoContingencia::class);

        $this->call(MHRetencionIVA::class);
        // En el catalogo de MH es 'Tipo de generacion del documento'
        $this->call(MHTipoGeneracionDocumento::class);
        $this->call(MHTipoEstablecimiento::class);

        $this->call(MHCodigoTipoServicio::class);
        $this->call(MHTipoItem::class);
        $this->call(MHDepartamento::class);

        $this->call(MHMunicipio::class);
        $this->call(MHUnidadMedida::class);
        $this->call(MHTributos::class);

        $this->call(MHCondicionOperacion::class);
        $this->call(MHFormaPago::class);
        $this->call(MHPlazo::class);

        $this->call(MHCodigoActividadEconomica::class);
        $this->call(MHPais::class);
        $this->call(MHDocumentosAsociados::class);

        $this->call(MHTipoDocumentoIdentificacionReceptor::class);
        $this->call(MHTipoDocumentoContingencia::class);
        $this->call(MHTipoInvalidacion::class);

        $this->call(MHTituloRemitenteBienes::class);
        $this->call(MHTipoDonacion::class);
        $this->call(MHRecintoFiscal::class);

        $this->call(MHRegimen::class);
        $this->call(MHTipoPersona::class);
        $this->call(MHTransporte::class);

        $this->call(MHIncoterms::class);
        $this->call(MHDomicilioFiscal::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
