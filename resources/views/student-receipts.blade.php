<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<img src = "Images/Logo.jpg" alt = "logo" height = "75px" width = "230px"/>

        <span class="right_header" style = "float:right;height:70px;width:200px;text-align:right;font-family:Sans-serif;font-size:13px;">

        <p><strong>Professional Schools</strong></br>
       <i> Ground Floor, PS Building</br>
       Matina Campus, Davao City</br>
     Telefax: (082) 305-0640 local 189</i>

</p>
        </span>
</div>
    <div id="mid">
      <div class="info">
        <hr style = "width:100%;text-align:left;background-color:red;"></hr>
        <br>

                    <div id="table" style = "font-size:12px;font-family:Sans-serif;">
                        
                       
                        <table>
                            
                            <thead>
                            <tr class="tabletitle">
                           
								<th class="student" align = "left" style = "width:150px"><strong>Student's Name</strong></th>
                                <th class="adviser" align = "left" style = "width:150px;"><strong>Adviser</strong></th>
                                <th class="degree" align = "left" style = "width:150px;"><strong>Degree Type</strong></th>
                                <th class="amount" align = "left" style = "width:120px;"><strong>Amount</strong></th>
                                <th class="reference" align = "left" style = "width:120px;">Reference Number</strong></th>
							
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($receipts as $data)
                                <tr>
                                   
                                    <td class="student" align = "left" style = "width:150px">{{$data->user->name}}</td>
                                    <td class="adviser" align = "left" style = "width:150px;">{{$data->researchPaper->adviser->name}}<</td>
                                    <td class="degree" align = "left" style = "width:150px;">{{$data->user->degree_type}}</td>
                                    <td class="amount" align = "left" style = "width:120px;">{{$data->amount}}</td>
                                    <td class="reference" align = "left" style = "width:120px;">{{$data->reference_number}}<</td>
                                </tr>
                                @endforeach

                            </tbody>
                       </table>
                      
                    </div>

                    <br>
                           
        
                    <div id ="table4" style = "border: 1px solid black;font-size:12px;font-family:Sans-serif;">
                        
                        <table>        
                            <tr class="tabletitle">
                                <td class="total" align = "left" style = "width:300px;">Total Payment Made by Students</td>
                                <td class="adviser" align = "right" style = "width:185px;"><strong>{{$totalAmount}}</strong></td><!--amount should be displayed here-->
                            </tr>
                        </table>
                    
                    </div>
    
                    <p style = "font-size:10px;font-family:Sans-serif;"><i>*Please see attached receipts. Thank you*</i></p>
                   
                    <div id="footer" style = "clear:both;position:absolute;bottom:50px;width:1250px;font-family:Sans-serif;font-size:13px;text-align:left;">
                       
                        <table>
                            <tr class="tabletitle">
                                <td class="adviser" align = "left" style = "width:150px;">Prepared by:</td>
                                <td class="currency" align = "right" style = "width:215px;">Recommending Approval:</td>
                                <td class="aamount" align = "right" style = "width:120px;">Noted by:</td> 
                            </tr>
                       </table>
                       <br>

                       <strong>
                        <table>
                            <tr class="tabletitle" style = "text-align:left;">
                                <td class="adviser" align = "left" style = "width:150px;">ARNIEMEE V. NUDALO</td>
                                <td class="currency" align = "right" style = "width:247px;">MA. LINDA B. ARQUIZA, EdD</td>
                                <td class="aamount" align = "right" style = "width:213px;">EUGENIO S. GUHAO JR., DM</td> 
                            </tr>
                       </table>
                       </strong>
                        <table>
                            <tr class="tabletitle" style = "text-align:left;font-size:12px;">
                                <td class="adviser" align = "left" style = "width:200px;">Research Administrative Assistant</td>
                                <td class="currency" align = "right" style = "width:100px;">Assistant Dean</td>
                                <td class="aamount" align = "right" style = "width:160px;">Dean</td> 
                            </tr>
                       </table>
                    
     </div>
    
</body>
</html>