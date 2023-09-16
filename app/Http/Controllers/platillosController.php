<?php

namespace App\Http\Controllers;

use App\Models\platillo;
use App\Models\promocion;
use App\Models\tipo_platillo;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class platillosController extends Controller
{
//    public function enviarCorreo(Request $request)
//    {
//        /*        require base_path("vendor/autoload.php");
//                //Create a new PHPMailer instance
//                $mail = new PHPMailer(true);
//                $mail->IsSMTP();
//
//        //Configuracion servidor mail
//                $mail->From = "henry-cotzajay@hotmail.com"; //remitente
//                $mail->SMTPAuth = true;
//                $mail->SMTPSecure = 'tls'; //seguridad
//                $mail->Host = "smtp.office365.com"; // servidor smtp
//                $mail->Port = 587; //puerto
//                $mail->Username = 'henry-cotzajay@hotmail.com'; //nombre usuario
//                $mail->Password = 'dinaly'; //contraseña
//
//                //Agregar destinatario
//                $mail->AddAddress('hcotzajay@rgp.org.gt');
//                $mail->Subject = 'Prueba de envio de correo a traves del servidor Outlok';
//                $mail->Body = 'Este es un mensaje de prueba';*/
//        try {
//
//            // Email server settings
//            $mail->SMTPDebug = 0;
//            $mail->isSMTP();
//            $mail->Host = 'smtp.example.com';             //  smtp host
//            $mail->SMTPAuth = true;
//            $mail->Username = 'henry-cotzajay@hotmail.com';   //  sender username
//            $mail->Password = 'dinaly';       // sender password
//            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
//            $mail->Port = 587;                          // port - 587/465
//
//            $mail->setFrom('hcotzajay@rgp.org.gt', 'Henry');
//            $mail->addAddress($request->emailRecipient);
//            $mail->addCC($request->emailCc);
//            $mail->addBCC($request->emailBcc);
//
//            $mail->addReplyTo('sender@example.com', 'SenderReplyName');
//
////            if (isset($_FILES['emailAttachments'])) {
////                for ($i = 0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
////                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
////                }
////            }
//
//
//            $mail->isHTML(true);                // Set email content format to HTML
//
//            $mail->Subject = $request->emailSubject;
//            $mail->Body = $request->emailBody;
//
//            // $mail->AltBody = plain text version of email body;
//
//            if (!$mail->send()) {
//                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
//            } else {
//                return back()->with("success", "Email has been sent.");
//            }
//
//        } catch (Exception $e) {
//            return back()->with('error', 'Message could not be sent.');
//        }
//    }


    public function obtenerPlatillosCreados()
    {
        $obtenerPlatillos = platillo::selectRaw('platillo.id_platillo, platillo.nombre_platillo, platillo.descripcion_platillo, platillo.id_tipo_platillo, platillo.precio, platillo.id_promocion, promocion.id_promocion, promocion.tipo_promocion, tipo_platillo.id_tipo, tipo_platillo.nombre')
            ->join('promocion', 'promocion.id_promocion', '=', 'platillo.id_promocion')
            ->join('tipo_platillo', 'tipo_platillo.id_tipo', '=', 'platillo.id_tipo_platillo')
            ->paginate(5);

        $obtenerPlatillos = json_encode($obtenerPlatillos);
        $obtenerPlatillos = json_decode($obtenerPlatillos);

        return response()->json([
            'platillos' => $obtenerPlatillos
        ], 200);
    }

    public
    function tipoPlatillos(Request $request)
    {
        $busquedaPlatillo = tipo_platillo::selectRaw('id_tipo,nombre')
            ->get();

        if ($busquedaPlatillo->isEmpty()) {
            return;
        }

        $busquedaPlatillo->toArray();

        $promociones = $this->obtenerPromociones();

        $enviarVista = [
            'promociones'   => $promociones,
            'tipoPlatillos' => $busquedaPlatillo
        ];
        return response()->json([
            'respuesta' => $enviarVista
        ], 200);
    }

    public
    function obtenerPromociones()
    {
        $buscarPromociones = promocion::selectRaw('id_promocion, tipo_promocion, monto_promocion')
            ->get();
        $buscarPromociones->toArray();
        return $buscarPromociones;
    }

    public
    function guardarPlatillo(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date("d-m-Y H:i:s");
        $nombrePlatillo = $request->datos['nombrePlatillo'];
        $descripcionPlatillo = $request->datos['descripcionPlatillo'];
        $tipoPlatillo = $request->datos['tipoPlatillo']['nombre'];
        $idTipoPlatillo = $request->datos['tipoPlatillo']['id_tipo'];
        $precioPlatillo = $request->datos['precioPlatillo'];
        $promocionPlatillo = $request->datos['promocion']['tipo_promocion'];
        $idPromocion = $request->datos['promocion']['id_promocion'];
        $montoPromocion = $request->datos['promocion']['monto_promocion'];

        $agregarPlatillo = new platillo();
        $agregarPlatillo->nombre_platillo = $nombrePlatillo;
        $agregarPlatillo->descripcion_platillo = $descripcionPlatillo;
        $agregarPlatillo->id_tipo_platillo = $idTipoPlatillo;
        $agregarPlatillo->precio = $precioPlatillo;
        $agregarPlatillo->id_promocion = $idPromocion;
        $agregarPlatillo->id_usuario = 1;//Pendiente de actualizar cuando se tenga los usuario y login creados
        $agregarPlatillo->fecha_creacion = date('Y-m-d H:i:s');
        if ($agregarPlatillo->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Platillo almacenado correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error'
            ], 403);
        }
    }

    public
    function guardarPlatilloEditado(Request $request)
    {
        $idPlatilloEditar = $request->datos['id_platillo'];
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date("d-m-Y H:i:s");
        $nombrePlatillo = $request->datos['nombre_platillo'];
        $descripcionPlatillo = $request->datos['descripcion_platillo'];
        $idTipoPlatillo = $request->datos['id_tipo'];
        $precioPlatillo = $request->datos['precio'];
        $idPromocion = $request->datos['id_promocion'];

        $editarPlatillo = platillo::find($idPlatilloEditar);
        $editarPlatillo->nombre_platillo = $nombrePlatillo;
        $editarPlatillo->descripcion_platillo = $descripcionPlatillo;
        $editarPlatillo->id_tipo_platillo = $idTipoPlatillo;
        $editarPlatillo->precio = $precioPlatillo;
        $editarPlatillo->id_promocion = $idPromocion;
        $editarPlatillo->id_usuario = 1;//Pendiente de actualizar cuando se tenga los usuario y login creados
        $editarPlatillo->fecha_creacion = date('Y-m-d H:i:s');
        if ($editarPlatillo->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Platillo editado correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error'
            ], 403);
        }

    }

    public
    function eliminarPlatillo(Request $request)
    {
        $idPlatilloEliminar = $request->datos;

        $platilloEliminar = platillo::where('id_platillo', '=', $idPlatilloEliminar)
            ->delete();

        if ($platilloEliminar === 1) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Platillo eliminado correctamente.',
            ], 200);
        }

        return response()->json([
            'title'   => 'Atención!',
            'message' => 'Ha ocurrido un error al eliminar el platillo.'
        ], 403);
    }

}
