<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family: Calibri ,Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 20px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f1f1;">
                    <tr>
                        <td align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="600"
                                style="background-color: #ffffff; border-radius: 5px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                                <tr>
                                    <td style="text-align: center; padding: 40px;">
                                        <img src="{{ asset('assets/crescentia.png') }}" alt="Crescentia" width="250">
                                        <h2 style="color: #000000; margin-top: -45px;">Confirmation d'email</h2>
                                        <p style="font-size: 16px;">Bonjour {{ $firstname }},</p>
                                        <p style="font-size: 16px;">
                                            Merci de vous être inscrit(e) sur Crescentia. Veuillez cliquer sur le
                                            bouton ci-dessous pour confirmer votre adresse email :
                                        </p>
                                        <p style="padding: 20px 0;">
                                            <a href="{{ $verificationUrl }}"
                                                style="background-color: #705e47; color: #fff; padding: 14px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                                                Confirmer mon adresse email
                                            </a>
                                        </p>
                                        <p style="font-size: 16px;">
                                            Si vous n'avez pas créé de compte sur Crescentia, vous pouvez ignorer cet
                                            email en toute sécurité.
                                        </p>
                                        <p style="font-size: 16px;">
                                            Cordialement,<br>
                                            L'équipe de Crescentia
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
