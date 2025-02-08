<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

use App\Models\CategoriaInsumo;
use App\Models\Especialidad;
use App\Models\Ficha;
use App\Models\HistorialClinico;
use App\Models\Insumo;
use App\Models\MedicoEspecialidad;
use App\Models\Paginacion;
use App\Models\Persona;
use App\Models\Sala;
use App\Models\ServicioMedico;
use App\Models\TipoMovimiento;
use App\Models\TurnoAtencion;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        Permission::create(['name' => 'ver lista de posts']);
        $role1 = Role::create(['name' => 'pruebaposts']);
        $role1->givePermissionTo('ver lista de posts');
        */


        //$roleX = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        /*
        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
*/

        // create demo users - Admin
        /*
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'telefono' => '78458123',
        ]);
        $user->assignRole($roleX);
        */
        
        //Usuarios Iniciales:
        //Admin:
        $roleAdmin = Role::create(['name' => 'Super-Admin']);
        $roleCliente = Role::create(['name' => 'Cliente']);        
        $roleProveedor = Role::create(['name' => 'Proveedor']);        
        $roleGerente = Role::create(['name' => 'Gerente']);
        $roleAdministradorEmpresa = Role::create(['name' => 'AdministradorEmpresa']);

        $roleMedico = Role::create(['name' => 'Medico']);
        $rolePaciente = Role::create(['name' => 'Paciente']);
        $roleRecepcionista = Role::create(['name' => 'Recepcionista']);

        
        //$roleArquitecto = Role::create(['name' => 'Arquitecto']);
        //$roleDiseñador = Role::create(['name' => 'Diseñador']);

        //CREACION DE UN ADMIN
        $personaCreated = Persona::create([                 
            'ci' => "0000000000",
            'nombre' => "Admin",
            'apellidopaterno' => "admin",
            'apellidomaterno' => "admin",
            'sexo' => "Masculino",
            'telefono' => "00000000",
            'direccion' => "En el espacio",
            
        ]);

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated->id           
        ]);
        //$user->removeRole('Cliente');        
        $user->assignRole($roleAdmin);


        

        //CREACION DE UN PERSONAL = Gerente
        $personaCreated3 = Persona::create([                 
            'ci' => "21323123",
            'nombre' => "Eliseo",
            'apellidopaterno' => "Perka",
            'apellidomaterno' => "Jimenez",
            'sexo' => "Masculino",
            'telefono' => "76523456",
            'direccion' => "C/ Bush 2do Anillo",
            
        ]);

        $user3 = \App\Models\User::factory()->create([
            'email' => 'eliseo@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated3->id           
        ]);

        $personal = \App\Models\Personal::create([
            'cargo' => 'Gerente Senior',                     

            'person_id' => $personaCreated3->id           
        ]);

        //$user->removeRole('Cliente');        
        $user3->assignRole($roleGerente);

        //CREACION DE UN PERSONAL = AdministradorEmpresa
        $personaCreated4 = Persona::create([                 
            'ci' => "8923232",
            'nombre' => "Fernando",
            'apellidopaterno' => "Martinez",
            'apellidomaterno' => "Gutierrez",
            'sexo' => "Masculino",
            'telefono' => "69812344",
            'direccion' => "C/ La ramada 2do anillo",
            
        ]);

        $user4 = \App\Models\User::factory()->create([
            'email' => 'fernando@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated4->id           
        ]);

        $personal = \App\Models\Personal::create([
            'cargo' => 'Administrador de la Empresa',                     

            'person_id' => $personaCreated4->id           
        ]);

        //$user->removeRole('Cliente');        
        $user4->assignRole($roleAdministradorEmpresa);

        
        //CREACION DE UN MEDICO
        $personaCreated5 = Persona::create([                 
            'ci' => "97156546",
            'nombre' => "Erasmo",
            'apellidopaterno' => "Hurtado",
            'apellidomaterno' => "Gutierrez",
            'sexo' => "Masculino",
            'telefono' => "3234564",
            'direccion' => "C/ Los mangales 6to Anillo Av/Alemena",
            
        ]);

        $user5 = \App\Models\User::factory()->create([
            'email' => 'medico@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated5->id           
        ]);

        $medico = \App\Models\Medico::create([
            'numero_licencia' => '854ASAASa1',
            'titulo_universidad' => 'Medico Cirujano',
            'origen_titulo' => 'Bolivia',
            'ano_titulacion' => 1992,
            'person_id' => $personaCreated5->id           
        ]);

        //$user->removeRole('Cliente');        
        $user5->assignRole($roleMedico);


        //CREACION DE UNA RECEPCIONISTA
        $personaCreated6 = Persona::create([                 
            'ci' => "97156546",
            'nombre' => "Erikao",
            'apellidopaterno' => "Hurtado",
            'apellidomaterno' => "Gutierrez",
            'sexo' => "Femenino",
            'telefono' => "3234564",
            'direccion' => "C/ Los mangales 6to Anillo Av/Alemena",
            
        ]);

        $user6 = \App\Models\User::factory()->create([
            'email' => 'recepcionista@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated6->id           
        ]);

        $recepcionista = \App\Models\Recepcionista::create([
            'turno_trabajo' => 'tarde',
            'fecha_contratacion' => '2022-10-21',            
            'person_id' => $personaCreated6->id           
        ]);

        //$user->removeRole('Cliente');        
        $user6->assignRole($roleRecepcionista);

        //CREACION DE UN PACIENTE
        $personaCreated7 = Persona::create([                 
            'ci' => "97156546",
            'nombre' => "Choco",
            'apellidopaterno' => "Hurtado",
            'apellidomaterno' => "Gutierrez",
            'sexo' => "Femenino",
            'telefono' => "3234564",
            'direccion' => "C/ Los mangales 6to Anillo Av/Alemena",
            
        ]);

        $user7 = \App\Models\User::factory()->create([
            'email' => 'paciente@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated7->id           
        ]);

        $paciente1 = \App\Models\Paciente::create([
            'tipo_sangre' => 'O+',
            'fecha_registro' => '2022-10-30',            
            'person_id' => $personaCreated7->id           
        ]);

        //$user->removeRole('Cliente');        
        $user7->assignRole($rolePaciente);


        //Acceso a pestañas
        
        //Gestion de Usuarios
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Usuarios']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Personal']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Roles']);        

        Permission::create(['name' => 'Visualizar pestaña de Gestion de Medicos']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Pacientes']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Recepcionistas']);                

        //Gestion de Atencion Medica
        Permission::create(['name' => 'Visualizar pestaña de Atencion Medica']);

        //Pestanas de atencion medica
        Permission::create(['name' => 'Ver pestaña de Especialidades']);
        Permission::create(['name' => 'Ver pestaña de Salas']);
        Permission::create(['name' => 'Ver pestaña de asignacion de especialidades medicas']);
        Permission::create(['name' => 'Ver pestaña de turnos de atencion']);

        //Gestion de Consulta Medica
        Permission::create(['name' => 'Visualizar pestaña de Consulta Medica']);

        //Pestanas de Consulta Medica
        Permission::create(['name' => 'Ver pestaña de Fichas']);
        Permission::create(['name' => 'Ver pestaña de Consulta Medica']);
        Permission::create(['name' => 'Ver pestaña de Historias Clinicas']);
        
        //Ver Consultas Realizadas
        Permission::create(['name' => 'Visualizar pestaña de Consultas Realizadas']);

        //Pestanas de Consultas Realizadas
        Permission::create(['name' => 'Ver pestaña de Consultas Medicas Realizadas']);

        //Gestion de Pagos
        Permission::create(['name' => 'Visualizar pestaña de Pagos']);

        //Pestanas de Gestion de Pagos
        Permission::create(['name' => 'Ver pestaña de Pagos']);    


        
        
        //Usuarios->Cliente, Proveedor, Personal, Roles----------------------------------------------------
        
        //Listar      
        
        Permission::create(['name' => 'Ver Lista de Personal']);
        Permission::create(['name' => 'Ver Lista de Roles']);
        Permission::create(['name' => 'Ver Lista de Permisos del Rol']);
        Permission::create(['name' => 'Ver Lista de Médicos']); 
        Permission::create(['name' => 'Ver Lista de Pacientes']); 
        Permission::create(['name' => 'Ver Lista de Recepcionistas']); 

        //Anadir        
        Permission::create(['name' => 'Añadir un Nuevo Personal']);
        Permission::create(['name' => 'Añadir un Nuevo Rol y sus Permisos']);
        Permission::create(['name' => 'Añadir un Nuevo Médico']);        
        Permission::create(['name' => 'Añadir un Nuevo Paciente']);        
        Permission::create(['name' => 'Añadir un Nuevo Recepcionista']);        

        //Editar        
        Permission::create(['name' => 'Editar Personal']);
        Permission::create(['name' => 'Editar Rol y sus Permisos']);
        Permission::create(['name' => 'Editar Médico']);
        Permission::create(['name' => 'Editar Paciente']);
        Permission::create(['name' => 'Editar Recepcionista']);

        
        //Eliminar        
        Permission::create(['name' => 'Eliminar Personal']);
        Permission::create(['name' => 'Eliminar Rol y sus Permisos']);
        Permission::create(['name' => 'Eliminar Médico']);
        Permission::create(['name' => 'Eliminar Paciente']);
        Permission::create(['name' => 'Eliminar Recepcionista']);       
        

        //Servicios Medicos
        
        //Especialidades----------------------

        //Listar
        Permission::create(['name' => 'Ver Lista de Especialidades']);
        //Añadir
        Permission::create(['name' => 'Añadir una Nueva Especialidad']);
        //Editar    
        Permission::create(['name' => 'Editar una Especialidad']);
        //Eliminar
        Permission::create(['name' => 'Eliminar una Especialidad']);        

        //Salas--------------------

        //Listar
        Permission::create(['name' => 'Ver Lista de Salas']);
        //Añadir
        Permission::create(['name' => 'Añadir una Nueva Sala']);
        //Editar    
        Permission::create(['name' => 'Editar una Sala']);     
        //Eliminar
        Permission::create(['name' => 'Eliminar una Sala']);  

        //Asignacion de especializacion medica

        //Listar
        Permission::create(['name' => 'Ver Lista de Asignaciones de Especialidades Medicas']);
        //Añadir
        Permission::create(['name' => 'Añadir una Nueva Asignacion de Especialidad Medica']);
        //Editar    
        Permission::create(['name' => 'Editar una asignacion de Especialidad Medica']);
        //Eliminar
        Permission::create(['name' => 'Eliminar una asignacion de Especialidad Medica']);  

        //Asignacion de turnos
        //Listar
        Permission::create(['name' => 'Ver Lista de Turnos de Atencion']);
        //Añadir
        Permission::create(['name' => 'Añadir un Nuevo Turno de Atencion']);
        //Editar    
        Permission::create(['name' => 'Editar un Turno de Atencion']);
        //Eliminar
        Permission::create(['name' => 'Eliminar un Turno de Atencion']); 

        // Consulta Medica

        //Fichas
        //Listar
        Permission::create(['name' => 'Ver Lista de Fichas']);
        //Añadir
        Permission::create(['name' => 'Añadir una Nueva Ficha']);
        //Editar    
        Permission::create(['name' => 'Editar una Ficha']);
        //Eliminar
        Permission::create(['name' => 'Eliminar una Ficha']); 

        //Pagar una Ficha
        Permission::create(['name' => 'Pagar una Ficha']); 
        //Atender una Ficha
        Permission::create(['name' => 'Puede atender una ficha medica']); 
        //Ver el historial clinico de un paciente
        Permission::create(['name' => 'Puede ver el historial clinico de un paciente']);         
        
        

        //Roles Asignados al Gerente

        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Usuarios');        
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Personal'); 
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Roles'); 

        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Medicos'); 
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Pacientes'); 
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Recepcionistas'); 

        
        $roleGerente->givePermissionTo('Ver Lista de Personal');
        $roleGerente->givePermissionTo('Ver Lista de Roles');
        $roleGerente->givePermissionTo('Ver Lista de Permisos del Rol');
        $roleGerente->givePermissionTo('Ver Lista de Médicos');
        $roleGerente->givePermissionTo('Ver Lista de Pacientes');
        $roleGerente->givePermissionTo('Ver Lista de Recepcionistas');
        
        
        $roleGerente->givePermissionTo('Añadir un Nuevo Personal');
        $roleGerente->givePermissionTo('Añadir un Nuevo Rol y sus Permisos');
        $roleGerente->givePermissionTo('Añadir un Nuevo Médico');
        $roleGerente->givePermissionTo('Añadir un Nuevo Paciente');
        $roleGerente->givePermissionTo('Añadir un Nuevo Recepcionista');

        
        $roleGerente->givePermissionTo('Editar Personal');
        $roleGerente->givePermissionTo('Editar Rol y sus Permisos');
        $roleGerente->givePermissionTo('Editar Médico');
        $roleGerente->givePermissionTo('Editar Paciente');
        $roleGerente->givePermissionTo('Editar Recepcionista');


        $roleGerente->givePermissionTo('Eliminar Personal');
        $roleGerente->givePermissionTo('Eliminar Rol y sus Permisos');
        $roleGerente->givePermissionTo('Eliminar Médico');
        $roleGerente->givePermissionTo('Eliminar Paciente');
        $roleGerente->givePermissionTo('Eliminar Recepcionista');

           
        
        $roleGerente->givePermissionTo('Visualizar pestaña de Atencion Medica');
        
        $roleGerente->givePermissionTo('Ver pestaña de Especialidades');
        $roleGerente->givePermissionTo('Ver pestaña de Salas');
        $roleGerente->givePermissionTo('Ver pestaña de asignacion de especialidades medicas');
        $roleGerente->givePermissionTo('Ver pestaña de turnos de atencion');      
        

        $roleGerente->givePermissionTo('Ver Lista de Especialidades');
        $roleGerente->givePermissionTo('Ver Lista de Salas');
        $roleGerente->givePermissionTo('Ver Lista de Asignaciones de Especialidades Medicas');
        $roleGerente->givePermissionTo('Ver Lista de Turnos de Atencion');
        

        $roleGerente->givePermissionTo('Añadir una Nueva Especialidad');        
        $roleGerente->givePermissionTo('Añadir una Nueva Sala');        
        $roleGerente->givePermissionTo('Añadir una Nueva Asignacion de Especialidad Medica');  
        $roleGerente->givePermissionTo('Añadir un Nuevo Turno de Atencion');        
        

        $roleGerente->givePermissionTo('Editar una Especialidad');
        $roleGerente->givePermissionTo('Editar una Sala');
        $roleGerente->givePermissionTo('Editar una asignacion de Especialidad Medica');
        $roleGerente->givePermissionTo('Editar un Turno de Atencion');
        

        $roleGerente->givePermissionTo('Eliminar una Especialidad');
        $roleGerente->givePermissionTo('Eliminar una Sala');
        $roleGerente->givePermissionTo('Eliminar una asignacion de Especialidad Medica');
        $roleGerente->givePermissionTo('Eliminar un Turno de Atencion');

        //Consulta Medica

        $roleGerente->givePermissionTo('Visualizar pestaña de Consulta Medica');

        $roleGerente->givePermissionTo('Ver pestaña de Fichas');
        $roleGerente->givePermissionTo('Ver pestaña de Consulta Medica');
        $roleGerente->givePermissionTo('Ver pestaña de Historias Clinicas'); 
        
        $roleGerente->givePermissionTo('Ver Lista de Fichas');
        $roleGerente->givePermissionTo('Añadir una Nueva Ficha');
        $roleGerente->givePermissionTo('Editar una Ficha');
        $roleGerente->givePermissionTo('Eliminar una Ficha');
        $roleGerente->givePermissionTo('Pagar una Ficha');
        $roleGerente->givePermissionTo('Puede atender una ficha medica');
        $roleGerente->givePermissionTo('Puede ver el historial clinico de un paciente');
        

        //Consultas Realizadas

        //$roleGerente->givePermissionTo('Visualizar pestaña de Consultas Realizadas');
        //$roleGerente->givePermissionTo('Ver pestaña de Consultas Medicas Realizadas');        


        //Gestion de Pagos
        $roleGerente->givePermissionTo('Visualizar pestaña de Pagos');

        $roleGerente->givePermissionTo('Ver pestaña de Pagos');
        

        // Roles Asignados al Administrador de la Empresa

        // $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Usuarios');
        // $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Clientes'); 
        // $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Proveedores'); 
        // $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Personal'); 
        // $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Roles'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Gestion de Insumos'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Categoria de Insumos'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Insumos'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Gestion de Inventarios'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Movimientos'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Gestion de Pedidos'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Mis Pedidos'); 
        // $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Cotizaciones'); 
        
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Clientes');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Proveedores');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Personal');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Roles');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Permisos del Rol');

        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Cliente');
        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Proveedor');
        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Personal');
        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Rol y sus Permisos');

        // $roleAdministradorEmpresa->givePermissionTo('Editar Cliente');
        // $roleAdministradorEmpresa->givePermissionTo('Editar Proveedor');
        // $roleAdministradorEmpresa->givePermissionTo('Editar Personal');
        // $roleAdministradorEmpresa->givePermissionTo('Editar Rol y sus Permisos');

        // $roleAdministradorEmpresa->givePermissionTo('Eliminar Cliente');
        // $roleAdministradorEmpresa->givePermissionTo('Eliminar Proveedor');
        // $roleAdministradorEmpresa->givePermissionTo('Eliminar Personal');
        // $roleAdministradorEmpresa->givePermissionTo('Eliminar Rol y sus Permisos');

        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Categorias de Insumos');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Insumos');

        // $roleAdministradorEmpresa->givePermissionTo('Añadir una Nueva Categoria de Insumo');
        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Insumo');

        // $roleAdministradorEmpresa->givePermissionTo('Editar una Categoria de Insumo');
        // $roleAdministradorEmpresa->givePermissionTo('Editar un Insumo');

        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de movimientos');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Informacion del movimiento');

        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Movimiento');

        

        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Pedidos');
        // $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Cotizaciones');

        // $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Pedido');
        // $roleAdministradorEmpresa->givePermissionTo('Añadir una Nueva Cotizacion');

        // $roleAdministradorEmpresa->givePermissionTo('Eliminar un Pedido');

        // $roleAdministradorEmpresa->givePermissionTo('Solicitar una cotizacion para un pedido');

        // $roleAdministradorEmpresa->givePermissionTo('Enviar una cotizacion de un pedido al cliente');

        // $roleAdministradorEmpresa->givePermissionTo('Ver cotizacion recibida');
        

        //Seeder de permisos para el recepcionista

        $roleRecepcionista->givePermissionTo('Visualizar pestaña de Gestion de Usuarios');       
        $roleRecepcionista->givePermissionTo('Visualizar pestaña de Gestion de Pacientes'); 
        $roleRecepcionista->givePermissionTo('Ver Lista de Pacientes');
        $roleRecepcionista->givePermissionTo('Añadir un Nuevo Paciente');
        $roleRecepcionista->givePermissionTo('Editar Paciente');

        $roleRecepcionista->givePermissionTo('Visualizar pestaña de Consulta Medica');

        $roleRecepcionista->givePermissionTo('Ver pestaña de Fichas');        
        $roleRecepcionista->givePermissionTo('Ver pestaña de Historias Clinicas'); 
        
        $roleRecepcionista->givePermissionTo('Ver Lista de Fichas');
        $roleRecepcionista->givePermissionTo('Añadir una Nueva Ficha');
        $roleRecepcionista->givePermissionTo('Editar una Ficha');
        $roleRecepcionista->givePermissionTo('Eliminar una Ficha');
        $roleRecepcionista->givePermissionTo('Pagar una Ficha');        
        $roleRecepcionista->givePermissionTo('Puede ver el historial clinico de un paciente');


        
        //Seeder de permisos para el paciente

        $rolePaciente->givePermissionTo('Visualizar pestaña de Consultas Realizadas');
        $rolePaciente->givePermissionTo('Ver pestaña de Consultas Medicas Realizadas');        

        // Seeders de cosas utiles para probar--------------------        

        //Especialidad
        $especialidad1 = Especialidad::create([
            'nombre' => 'cardiologia',
            'descripcion' => 'Especialidad médica que se ocupa del diagnóstico y tratamiento de las enfermedades del corazón y del sistema circulatorio.',
        ]);

        //Medico-Especialidad
        $medico_especialidad1 = MedicoEspecialidad::create([            
            'id_medico' => $medico->id,
            'id_especialidad' => $especialidad1->id,
            'titulo_especialidad' => 'Medico Cirujano',
            'origen_especialidad' => 'Bolivia',
            'ano_especialidad' => 1992
        ]);

        $sala1 = Sala::create([
            'codigo' => 'A01',
            'tipo' => 'Observacion',            
        ]);


        $turnoatencion = TurnoAtencion::create([
            'horario' => 'manana',
            'hora_inicio' => '08:00',
            'hora_fin' => '09:00',
            'dias_servicio' => ["lunes", "martes"],
            'cantidad_fichas' => 10,
            'precio' => 120,
            'medico_especialidad_id' => $especialidad1->id,
            'sala_id' => $sala1->id
        ]);

        //CREACION DE UN HISTORIAL CLINICO
        $historial_clinico = HistorialClinico::create([
            'diagnostico_principal' => 'ninguno',
            'alergias' => 'ninguno',
            'antecedentes_familiares' => 'ninguno',
            'antecedentes_personales' => 'ninguno',
            'tratamientos_cronicos' => 'ninguno',
            'estado' => 'vivo',
            'paciente_id' => $paciente1->id
        ]);

        //CREACION DE UNA FICHA
        $ficha = Ficha::create([
            'estado' => 'Pagado en espera de atencion',
            'recepcionista_id' => $recepcionista->id,
            'paciente_id' => $paciente1->id,
            'turno_atencion_id' => $turnoatencion->id
        ]);

        
        


        
        //Paginacion-------------------------------------------------

        Paginacion::create([            
            'pagina' => 'personal',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'roles',
            'contador' => 0,
        ]);        

        Paginacion::create([            
            'pagina' => 'pago',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'especialidad',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'sala',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'medico',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'paciente',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'recepcionista',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'medicoespecialidad',
            'contador' => 0,
        ]);
        
        Paginacion::create([            
            'pagina' => 'turnoatencion',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'ficha',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'consulta',
            'contador' => 0,
        ]);

        //Run Migrations

        //php artisan migrate:fresh --seed --seeder=PermissionsSeeder
        
        //Create a new model
        //php artisan make:model NombreModelo -m
        
        //Crear un nuevo componente con livewire
        //php artisan make:livewire NombreComponente
        

        //Comando para ejectutar ngrok
        //ngrok config add-authtoken 2jFtrIoioGX8QxJKIRvsgj5ne4v_5PP6jv1BAbsaGMVqjkCqW
        //ngrok http http://localhost:8000

    }
}
