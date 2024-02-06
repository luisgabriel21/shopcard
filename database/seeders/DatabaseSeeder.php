<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Appointment;
use App\Models\Appointment_Messages;
use App\Models\Plan;
use App\Models\Pqrs;
use App\Models\Pqrsmessage;
use App\Models\Professional;
use App\Models\Professional_Services;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use OpenSpout\Common\Entity\Row;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'id' => Role::ADMIN,
            'name'=> 'Administrador',
        ]);

        Role::create([
            'id' => Role::PARTNER,
            'name'=> 'Aliado',
        ]);

        Role::create([
            'id' => Role::AFFILIATE,
            'name'=> 'Afiliado',
        ]);

        User::factory()->create([
            'role_id' => Role::ADMIN,
            'name' => 'Administrador Shopcard',
            'email' => 'admin@shopcard.com',
            'password'  => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'role_id' => Role::PARTNER,
            'name' => 'Centro Médico Especialistas del Chocó',
            'email' => 'aliado@shopcard.com',
            'password'  => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'role_id' => Role::AFFILIATE,
            'name' => 'Andrés Felipe Mosquera',
            'email' => 'afiliado@shopcard.com',
            'password'  => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        // Crear 2 administradores
        User::factory(1)->create(['role_id' => 1]); // Asociamos el role_id 1 (admin)

        // Crear 3 aliados
        User::factory(5)->create(['role_id' => 2]); // Asociamos el role_id 2 (aliado)

        // Crear 20 afiliados
        User::factory(50)->create(['role_id' => 3]); // Asociamos el role_id 3 (afiliado)
          
                // Crear 5 planes de membresía diferentes
                Plan::create([
                    'name' => 'Plan Bronce',
                    'description' => 'Acceso durante 1 mes con todas las funciones y descuentos.',
                    'price' => 25000,
                    'duration_months' => 1,
                    'image' => 'basic_plan_image.jpg',
                ]);
        
                Plan::create([
                    'name' => 'Plan Plata',
                    'description' => 'Acceso durante 3 meses con todas las funciones y descuentos.',
                    'price' => 40000,
                    'duration_months' => 3,
                    'image' => 'standard_plan_image.jpg',
                ]);
        
                Plan::create([
                    'name' => 'Plan Oro',
                    'description' => 'Acceso durante 6 meses con todas las funciones y descuentos.',
                    'price' => 70000,
                    'duration_months' => 6,
                    'image' => 'premium_plan_image.jpg',
                ]);
        
                Plan::create([
                    'name' => 'Plan Platino',
                    'description' => 'Acceso durante 1 año con todas las funciones y descuentos.',
                    'price' => 120000,
                    'duration_months' => 12,
                    'image' => 'business_plan_image.jpg',
                ]);
        
                Plan::create([
                    'name' => 'Plan Diamante',
                    'description' => 'Acceso durante 2 años con todas las funciones y descuentos.',
                    'price' => 200000,
                    'duration_months' => 24,
                    'image' => 'vip_plan_image.jpg',
                ]);

        // Obtener todos los usuarios con rol "afiliado"
        $afiliados = User::where('role_id', 3)->get(); // Asegúrate de que 3 sea el ID correcto del rol "afiliado"

        // Obtener todos los planes
        $planes = Plan::all();

        // Asociar usuarios afiliados con planes aleatorios
        foreach ($afiliados as $afiliado) {
            $planAleatorio = $planes->random();

            Subscription::create([
                'user_id' => $afiliado->id,
                'plan_id' => $planAleatorio->id,
                'start_date' => now(),
                'end_date' => now()->addMonths($planAleatorio->duration_months),
                'status' => 'activo', // Puedes ajustar el estado según tus necesidades
                'payment_method' => 'tarjeta', // Puedes ajustar el método de pago según tus necesidades
            ]);
        }
        
        // Obtener al menos 10 usuarios
        $usuarios = User::all()->take(30);

        foreach ($usuarios as $usuario) {
            // Seleccionar aleatoriamente otro usuario como el "target_user"
            $targetUser = User::where('id', '!=', $usuario->id)->inRandomOrder()->first();

            Pqrs::create([
                'user_id' => $usuario->id,
                'target_user_id' => $targetUser->id,
                'type' => $this->generateRandomType(),
                'description' => $this->generateRandomDescription(),
                'is_active' => true,
            ]);
        }

        // Obtener todas las PQRS
        $pqrs = PQRS::all();

        foreach ($pqrs as $pqr) {
            // Obtener al menos 2 usuarios (reemplaza con la lógica que necesites)
            $usuarios = User::where('id', '!=', $pqr->user_id)->take(2)->get();

            // Crear mensajes para la PQRS
            foreach ($usuarios as $usuario) {
                Pqrsmessage::create([
                    'pqrs_id' => $pqr->id,
                    'sender_id' => $usuario->id,
                    'message' => $this->generateRandomMessage(),
                ]);
            }
        }


        // Obtener usuarios con rol "aliado"
        $aliados = User::where('role_id', 2)->get(); // Asegúrate de que 2 sea el ID correcto del rol "aliado"

        foreach ($aliados as $aliado) {
            $cantidadProfesionales = rand(2, 5);

            // Crear entre 2 y 5 profesionales para cada aliado
            for ($i = 0; $i < $cantidadProfesionales; $i++) {
                Professional::create([
                    'name' => $this->generateRandomNameProfessional(),
                    'specialty' => $this->generateRandomSpecialty(),
                    'license_number' => $this->generateRandomLicenseNumber(),
                    'phone_number' => $this->generateRandomPhoneNumber(),
                    'email' => $this->generateRandomEmail(),
                    'description' => $this->generateRandomDescription(),
                    'user_id' => $aliado->id,
                ]);
            }
        }

     // Obtener usuarios con rol "aliado"
     $aliados = User::where('role_id', 2)->get(); // Asegúrate de que 2 sea el ID correcto del rol "aliado"

     foreach ($aliados as $aliado) {
         $cantidadServicios = rand(5, 10);

         // Crear entre 5 y 10 servicios para cada aliado
         for ($i = 0; $i < $cantidadServicios; $i++) {
             Service::create([
                 'name' => $this->generateRandomNameService(),
                 'description' => $this->generateRandomDescription(),
                 'category' => $this->generateRandomCategory(),
                 'price' => $this->generateRandomPrice(),
                 'user_id' => $aliado->id,
             ]);
         }
     }

// Obtener usuarios con rol "aliado"
$aliados = User::where('role_id', 2)->get(); // Asegúrate de que 2 sea el ID correcto del rol "aliado"

// Meses para los cuales se crearán las agendas
$meses = ['January', 'February', 'March', 'April', 'May'];

foreach ($aliados as $aliado) {
    // Obtener profesionales asociados a este aliado
    $profesionales = $aliado->professionals;

    // Verificar si hay profesionales asociados antes de iterar
    if ($profesionales->isNotEmpty()) {
        foreach ($profesionales as $profesional) {
            foreach ($meses as $mes) {
                // Crear agendas para cada día laborable del mes
                $diasLaborables = Carbon::create($mes)->daysInMonth;
                for ($dia = 1; $dia <= $diasLaborables; $dia++) {
                    $fecha = Carbon::createFromDate(null, Carbon::parse($mes)->month, $dia);
                    if ($fecha->isWeekday()) {
                        $startTimes = ['08:00:00', '12:00:00', '17:00:00'];
                        foreach ($startTimes as $startTime) {
                            Schedule::create([
                                'user_id' => $aliado->id,
                                'professional_id' => $profesional->id,
                                'schedule_date' => $fecha->addDays(rand(0, 4)),
                                'start_time' => $startTime,
                                'end_time' => $this->generateEndTime($startTime),
                            ]);
                        }
                    }
                }
            }
        }
    }
}
        
       // Obtener todos los profesionales
       $profesionales = Professional::all();

       foreach ($profesionales as $profesional) {
           // Obtener servicios del mismo usuario (aliado) del profesional
           $servicios = Service::where('user_id', $profesional->user_id)->get();

           if ($servicios->count() > 0) {
               // Asociar al menos un servicio a cada profesional
               $servicioAleatorio = $servicios->random();

               Professional_Services::create([
                   'professional_id' => $profesional->id,
                   'service_id' => $servicioAleatorio->id,
               ]);
           }
       }

      

       // Obtener usuarios con rol "aliado"
       $aliados = User::where('role_id', 2)->get(); // Asegúrate de que 2 sea el ID correcto del rol "aliado"
       
       foreach ($aliados as $aliado) {
           // Obtener profesionales asociados a este aliado
           $profesionales = $aliado->professionals;
       
           // Verificar si hay profesionales asociados antes de iterar
           if ($profesionales->isNotEmpty()) {
               foreach ($profesionales as $profesional) {
                   // Obtener servicios del mismo usuario (aliado) del profesional
                   $servicios = Service::where('user_id', $aliado->id)->get();
       
                   // Verificar si hay servicios asociados antes de iterar
                   if ($servicios->isNotEmpty()) {
                       foreach ($servicios as $servicio) {
                           // Crear citas para todo el año 2024
                           $inicioAnio = Carbon::create(2024, 1, 1, 8, 0, 0); // Fecha de inicio del año 2024
                           $finAnio = Carbon::create(2024, 12, 31, 17, 0, 0); // Fecha de fin del año 2024
       
                           for ($i = $inicioAnio->copy(); $i->lte($finAnio); $i->addDay()) {
                               // Obtener citas existentes para el profesional en la fecha actual
                               $citasDiarias = Appointment::where('professional_id', $profesional->id)
                                   ->whereDate('appointment_datetime', $i->toDateString())
                                   ->count();
       
                               // Si el profesional ya tiene 5 citas, no agregar más
                               if ($citasDiarias >= 5) {
                                   continue;
                               }
       
                               $fechaHoraCita = $i->copy()->setHour(rand(8, 17))->setMinute(rand(0, 45))->setSecond(0);
       
                               // Definir estados de las citas según el mes
                               $estadoCita = 'Solicitada'; // Por defecto, las citas futuras son solicitadas
                               if ($i->month == 1) {
                                   $estadoCita = rand(0, 4) > 0 ? 'Aprobada' : 'Cancelada'; // En enero, la mayoría aprobadas, algunas canceladas
                               }
       
                               // Obtener usuarios con rol "afiliado"
                               $afiliados = User::where('role_id', 3)
                                   ->inRandomOrder()
                                   ->limit(2)
                                   ->get(); // Asegúrate de que 3 sea el ID correcto del rol "afiliado"
       
                               foreach ($afiliados as $afiliado) {
                                   Appointment::create([
                                       'user_id' => $aliado->id,
                                       'affiliate_id' => $afiliado->id, // Se asume que el aliado también es el afiliado en este caso
                                       'professional_id' => $profesional->id,
                                       'service_id' => $servicio->id,
                                       'appointment_datetime' => $fechaHoraCita,
                                       'status' => $estadoCita,
                                   ]);
                               }
                           }
                       }
                   }
               }
           }
       }
       


       // Obtener todas las citas
       $citas = Appointment::all();

       foreach ($citas as $cita) {
           // Obtener usuarios relacionados a la cita (aliado y afiliado)
           $usuariosRelacionados = User::whereIn('id', [$cita->user_id, $cita->affiliate_id])->get();

           foreach ($usuariosRelacionados as $usuario) {
               // Crear interacciones de usuario en la cita
               Appointment_Messages::create([
                   'appointment_id' => $cita->id,
                   'user_id' => $usuario->id,
                   'message' => $this->generateRandomMessage(),
               ]);
           }
        }


    
}
// Método para generar la hora de finalización basada en la hora de inicio
private function generateEndTime($startTime)
{
    $endTime = Carbon::parse($startTime)->addHours(4); // Se asume una duración de 4 horas
    return $endTime->format('H:i:s');
}

    private function generateRandomStatus()
    {
     $status = [
         'Solicitada' => 'Solicitada',
         'Aprobada' => 'Aprobada',
         'Cancelada' => 'Cancelada',
     ];
     return $status[array_rand($status)];
      
    }

    private function generateRandomTime()
    {
        // Puedes personalizar la generación de tiempos según tus necesidades
        return now()->addHours(rand(8, 17))->format('H:i:s');
    }

    private function generateRandomCategory()
    {
        // Puedes personalizar la generación de categorías según tus necesidades
        $categories = [
            'otros' => 'Otros',
            'medicos' => 'Servicios Médicos',
            'esteticos' => 'Servicios Estéticos',
            'odontologicos' => 'Servicios Odontológicos',
            'dermatologia' => 'Dermatología',
            'cirugia_plastica' => 'Cirugía Plástica',
            'ginecologia' => 'Ginecología',
            'oftalmologia' => 'Oftalmología',
            'nutricion' => 'Nutrición y Dietética',
            'fisioterapia' => 'Fisioterapia',
            'psicologia' => 'Psicología',
            'radiologia' => 'Radiología',
            'pedicura' => 'Pedicura',
            'corte_cabello' => 'Corte de Cabello',
            'manicura' => 'Manicura',
            'depilacion' => 'Depilación',
            'maquillaje' => 'Maquillaje',
            'masajes' => 'Masajes',
            'tratamientos_capilares' => 'Tratamientos Capilares',
            'podologia' => 'Podología',
            'bronceado' => 'Bronceado',
            // ... Agrega más categorías según tus necesidades
        ];
        return $categories[array_rand($categories)];
    }

    private function generateRandomPrice()
    {
        // Puedes personalizar la generación de precios según tus necesidades
        return rand(10000, 200000);
    }

    private function generateRandomNameProfessional()
    {
        // Puedes personalizar la generación de nombres según tus necesidades
        $nombresApellidosLatinos = [
            'Juan González',
            'Ana Rodríguez',
            'Carlos Martínez',
            'Maria López',
            'Pedro Hernández',
            'Laura Pérez',
            'Luis Díaz',
            'Isabel Sánchez',
            'Miguel Ramírez',
            'Sofia Flores',
            'Javier Gómez',
            'Valeria Torres',
            'Francisco Reyes',
            'Fernanda Jiménez',
            'Jose Vargas',
            'Camila Molina',
            'Ricardo Ruiz',
            'Daniela Castro',
            'Manuel Ortega',
            'Adriana Herrera',
            'Alejandro Medina',
            'Gabriela Aguilar',
            'Jorge Castillo',
            'Liliana Ríos',
            'Diego Acosta',
            'Patricia Mendoza',
            'Emilio Rojas',
            'Monica Palacios',
            'Victor Cordero',
            'Diana Morales',
            'Roberto Navarro',
            'Juliana Salazar',
            'Fernando Duarte',
            'Catalina Paredes',
            'Raul Lozano',
            'Elena Núñez',
            'Antonio Cervantes',
            'Raquel Gallegos',
            'Mario Rosales',
            'Natalia Aguirre',
            'Lorenzo Delgado',
            'Beatriz Soto',
            'Hector Moya',
            'Celeste Rangel',
            'Guillermo Pacheco',
            'Lucia Cisneros',
            'Oscar Ibarra',
            'Vanessa Peña'
        ];
        
        return $nombresApellidosLatinos[array_rand($nombresApellidosLatinos)];
    }

    private function generateRandomNameService()
    {
        // Puedes personalizar la generación de nombres según tus necesidades
        $nombresServicios = [
            'Consulta General',
            'Examen de Sangre',
            'Consulta Dermatológica',
            'Cirugía de Nariz',
            'Tratamiento Facial',
            'Blanqueamiento Dental',
            'Consulta Ginecológica',
            'Examen de Vista',
            'Consulta Nutricional',
            'Sesión de Fisioterapia',
            'Consulta Psicológica',
            'Radiografía de Torax',
            'Pedicura Profesional',
            'Corte de Cabello Moderno',
            'Manicura Express',
            'Depilación con Cera',
            'Maquillaje para Eventos',
            'Masaje Relajante',
            'Tratamiento Capilar Hidratante',
            'Podología Preventiva',
            'Bronceado Natural',
            'Consulta Odontológica',
            'Cirugía Estética Facial',
            'Consulta de Obstetricia',
            'Examen de Ojos Secos',
            'Tratamiento Antienvejecimiento',
            'Depilación de Piernas',
            'Diseño de Peinado',
            'Uñas de Gel',
            'Depilación con Láser',
            'Maquillaje de Novia',
            'Masaje Deportivo',
            'Tratamiento Capilar Reparador',
            'Podología Correctiva',
            'Bronceado con Aerógrafo',
            'Consulta Ortopédica',
            'Rinoplastia',
            'Control Prenatal',
            'Examen de Glaucoma',
            'Peeling Facial',
            'Cirugía de Mentón',
            'Masaje Shiatsu',
            'Tratamiento Capilar Anticaspa',
            'Podología Deportiva',
            'Bronceado en Cabina',
            'Cirugía de Párpados',
            'Consulta Cardiológica',
            'Microdermoabrasión Facial',
            'Implantes Dentales',
        ];
        return $nombresServicios[array_rand($nombresServicios)];
    }

    private function generateRandomSpecialty()
    {
        // Puedes personalizar la generación de especialidades según tus necesidades
        $specialties = [
            'Medicina General',
            'Análisis Clínicos',
            'Dermatología',
            'Cirugía Plástica',
            'Estética Facial',
            'Odontología General',
            'Ginecología',
            'Oftalmología',
            'Nutrición',
            'Fisioterapia',
            'Psicología',
            'Radiología',
            'Pedicura',
            'Corte de Cabello',
            'Manicura',
            'Depilación',
            'Maquillaje',
            'Masoterapia',
            'Tratamientos Capilares',
            'Podología',
            'Bronceado',
            'Odontología General',
            'Cirugía Estética Facial',
            'Obstetricia',
            'Oftalmología',
            'Tratamientos Antienvejecimiento',
            'Depilación',
            'Estilismo',
            'Manicura y Pedicura',
            'Depilación Láser',
            'Maquillaje Profesional',
            'Masaje Deportivo',
            'Tratamientos Capilares',
            'Podología Correctiva',
            'Bronceado',
            'Ortopedia',
            'Cirugía Estética Facial',
            'Control Prenatal',
            'Oftalmología',
            'Tratamientos Faciales',
            'Cirugía Estética Facial',
            'Masaje Terapéutico',
            'Tratamientos Capilares',
            'Podología Deportiva',
            'Bronceado en Cabina',
            'Cirugía de Párpados',
            'Cardiología',
            'Microdermoabrasión',
            'Implantología',
        ];
        return $specialties[array_rand($specialties)];
    }

    private function generateRandomLicenseNumber()
    {
        // Puedes personalizar la generación de números de licencia según tus necesidades
        return 'LICENSE' . rand(1000, 9999);
    }

    private function generateRandomPhoneNumber()
    {
        // Puedes personalizar la generación de números de teléfono según tus necesidades
        return '311-' . rand(999999, 9999999);
    }

    private function generateRandomEmail()
    {
        // Puedes personalizar la generación de correos electrónicos según tus necesidades
        return 'professional' . rand(1, 100) . '@example.com';
    }

    private function generateRandomDescriptionPro()
    {
        // Puedes personalizar la generación de descripciones según tus necesidades
        return 'Descripción del profesional.';
    }

    
    private function generateRandomMessage()
    {
        // Puedes personalizar la generación de mensajes según tus necesidades
        $messages = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
            'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ];
        return $messages[array_rand($messages)];
    }

    private function generateRandomType()
    {
        $types = ['Peticion', 'Queja', 'Reclamo', 'Solicitud'];
        return $types[array_rand($types)];
    }

    private function generateRandomDescription()
    {
        // Puedes personalizar la generación de descripciones según tus necesidades
        $descriptions = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
            'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ];
        return $descriptions[array_rand($descriptions)];
    }
}
