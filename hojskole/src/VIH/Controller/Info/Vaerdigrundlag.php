<?php
class VIH_Controller_Info_Vaerdigrundlag extends k_Controller
{
    function GET()
    {
        $title = 'Værdigrundlag';
        $meta['description'] = '';
        $meta['keywords'] = '';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        return '
        <h1>Formål og værdigrundlag</h1>

        <h2>§ 1</h2>
        <p>Vejle Idrætshøjskole, der er oprettet i 1942 under navnet Den Jyske Idrætsskole, er en uafhængig og selvejende institution med hjemsted i Vejle Kommune.</p>
        <h2>Formål</h2>
        <p>Vejle Idrætshøjskoles formål er inden for rammerne af de gældende regler om frie kostskoler at drive en højskole med særligt henblik på at virke inden for idrætten.</p>
        <h2>Værdigrundlag</h2>
        <p>Vejle Idrætshøjskoles skolevirksomhed bygger på troen på det værdige menneske af krop og ånd, som det udtrykkes i et personligt liv og som kan realiseres ved at hjælpe eleverne med at udvikle deres formelle og reelle kompetencer gennem livsoplysning og demokratisk dannelse. Derfor vægter Vejle Idrætshøjskole den humanistiske dannelse højt, for herigennem at udvikle elevernes forståelse og respekt for menneskers kvaliteter på trods af forskelligheder.</p>
        <p>Vejle Idrætshøjskoles idrætssyn bygger på ideen om at idrætten har sin egen værdi og derigennem kan bidrage til den humanistiske dannelse.</p>
        ';
    }

}