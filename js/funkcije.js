var brojDrugihOsiguranika = 0;
function IzabranaPolisa()
{
    //brisem sve elemente u divu dodatniOsiguranici...
    var dodatniOsiguranici = document.getElementById('dodatniOsiguranici'); //uzet div!        
    while(dodatniOsiguranici.childNodes.length > 0){
        dodatniOsiguranici.removeChild(dodatniOsiguranici.childNodes[0]);        
    }
    var vrstaPolise = document.getElementById('vrsta_polise').value;
    if(vrstaPolise === 'grupno')
    {        
        var tabela = document.createElement("TABLE");
        tabela.setAttribute("id", "tabela");
        tabela.setAttribute("width", "100%");
        tabela.setAttribute("border", "1");
        //pravih zaglavlje tabele...
        var tr = document.createElement("TR");

        var th = document.createElement("TH");        
        th.innerHTML = "Ime i prezime";
        tr.appendChild(th);

        var th = document.createElement("TH");        
        th.innerHTML = "Datum rodjenja";
        tr.appendChild(th);        

        var th = document.createElement("TH");        
        th.innerHTML = "Broj pasosa";
        tr.appendChild(th);

        var th = document.createElement("TH");        
        th.innerHTML = "Akcija";
        tr.appendChild(th);        
        
        tabela.appendChild(tr);
        //kraj zaglavlja tabele...

        dodatniOsiguranici.appendChild(tabela);

        var btn = document.createElement("BUTTON");
        btn.setAttribute("type", "button");
        btn.setAttribute("id", "dodajNovogOsiguranika");
        btn.setAttribute("class", "btn btn-secondary");
        btn.addEventListener("click", dodajNovogOsiguranika);
        btn.innerHTML = "Dodaj novog osiguranika";
        dodatniOsiguranici.appendChild(btn);

        dodajNovogOsiguranika();
    }
}
function dodajNovogOsiguranika()
{
    var i = brojDrugihOsiguranika;

    var tabela = document.getElementById("tabela");
    var tr = document.createElement("TR");
    tr.setAttribute("id", "row_" + i);
    tabela.appendChild(tr);

    var td = document.createElement("TD");
    var input = document.createElement("INPUT");
    input.setAttribute("name", "inpIP_" + i);
    input.setAttribute("id", "inpIP_" + i);
    input.required = true;
    td.appendChild(input);
    tr.appendChild(td);

    var td = document.createElement("TD");
    var input = document.createElement("INPUT");
    input.setAttribute("type", "date");
    input.setAttribute("name", "inpDR_" + i);
    input.setAttribute("id", "inpDR_" + i);
    input.required = true;
    td.appendChild(input);
    tr.appendChild(td);

    var td = document.createElement("TD");
    var input = document.createElement("INPUT");
    input.setAttribute("name", "inpBP_" + i);
    input.setAttribute("id", "inpBP_" + i);
    input.required = true;
    td.appendChild(input);
    tr.appendChild(td);

    var td = document.createElement("TD");
    var btn = document.createElement("BUTTON");
    btn.addEventListener("click", ukloniNovogOsiguranika);
    btn.setAttribute("name", "btnDNO_" + i);    
    btn.setAttribute("id", "btnDNO_" + i);    
    btn.setAttribute("type", "button");
    btn.setAttribute("class", "btn btn-danger");
    btn.innerHTML = "Ukloni";
    td.appendChild(btn);
    tr.appendChild(td);  
    
    brojDrugihOsiguranika++;

}
function ukloniNovogOsiguranika(event)
{   
    var i = event.target.name.substring(7, event.target.name.length);
    
    var btn = document.getElementById("btnDNO_" + i);    
    var inpIP = document.getElementById("inpIP_" + i);
    var inpDR = document.getElementById("inpDR_" + i);
    var inpBP = document.getElementById("inpBP_" + i);
    btn.parentElement.removeChild(btn);
    inpIP.parentElement.removeChild(inpIP);
    inpDR.parentElement.removeChild(inpDR);
    inpBP.parentElement.removeChild(inpBP);        

    var row = document.getElementById("row_" + i);
    row.parentElement.removeChild(row);

    if(document.getElementById("tabela").childNodes.length === 1)
    {
        dodajNovogOsiguranika();        
    }

}
function IzracunajBrojDana()
{
    var datumPutovanjaOd = document.getElementById('datumPutovanjaOd').value;
    var datumPutovanjaDo = document.getElementById('datumPutovanjaDo').value;    

    var d1 = new Date(datumPutovanjaOd);
    var d2 = new Date(datumPutovanjaDo);

    var razlikaDani = Math.round((d2-d1)/(1000*60*60*24));
    
    var brojDana = document.getElementById("brojDana");    

    if (razlikaDani > 0) {
        brojDana.innerHTML = 'Ukupan broj dana: '+ razlikaDani;
    } else {
        brojDana.innerHTML = '';
    }
}
function prikaziSakriDodatnaLica()
{
    var dodatnaLica = document.getElementById('dodatnaLica');
    var btnDodatnaLica = document.getElementById('btnDodatnaLica');

    dodatnaLica.hidden = !dodatnaLica.hidden;
    
    if(dodatnaLica.hidden){
        btnDodatnaLica.value = 'Prikazi dodatna lica na polisi';
    }else{
        btnDodatnaLica.value = 'Sakri dodatna lica na polisi';
    }
}