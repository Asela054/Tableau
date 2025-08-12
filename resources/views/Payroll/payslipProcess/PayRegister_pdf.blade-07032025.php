<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Laravel PDF</title>
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"-->
    <style type="text/css">
	@page { 
		/*
		size: 50.5cm 21cm landspace;
		*/ 
		font-size:8px;
		margin:0.8cm;
	}
	/**/
	hr.pgbrk {
		page-break-after:always;
		border:0;
	}
	
	#header,
	#footer {
	  position: fixed;
	  left: 0;
		right: 0;
		color: #aaa;
		font-size: 0.9em;
	}
	#header {
	  top: 0;
		border-bottom: 0.1pt solid #aaa;
	}
	#footer {
	  bottom: 0;
	  border-top: 0.1pt solid #aaa;
	}
	.page-number:before {
	  content: "Page " counter(page);
	}
	
	table.pdf_data tbody tr td{
		padding-left:2px;/*10px*/
		padding-right:1px;/*10px*/
		text-align:right;
	}
	/**/
	table.pdf_data thead tr th{
		text-align:center !Important;
	}
	
	table.pdf_data tbody tr td:nth-child(1),
	table.pdf_data tbody tr td:nth-child(2){
		text-align:left;
	}
	table.pdf_data thead tr th,
	table.pdf_data tbody tr td{
		border:1px solid grey; width:37px !Important; max-width:37px;/*47px*/
	}
	table.pdf_data tbody tr td:nth-child(2){
		width:75px !Important; max-width:75px;/*125px*/
	}
	table.pdf_data tbody tr:last-child td{
		border:none !Important;
		border-bottom:solid double grey;
		font-weight:bold;
	}
	
	table.pdf_data tfoot tr td{
		text-align:center;
		
	}
	table.pdf_data tfoot tr.sign_row td{
		height:50px;
	}
	table.pdf_data tfoot tr.sign_row td.sign_col{/*td:nth-child(odd)*/
		border-bottom:1px dashed grey;
	}
	
	</style>
  </head>
  <body>
    <div id="" style="padding-left:20px;padding-bottom:20px; padding-right:10px;">
        <table width="100%" style="" border="0" cellpadding="2" cellspacing="0">
            <tr>
                <td><strong>MULTI OFFSET (PVT) LTD</strong></td>
                <td align="right">PAY REGISTER</td>
            </tr>
            <tr>
                <td>NEGOMBO</td>
                <td align="right">Department: {{$sect_name}}</td>
            </tr>
            <tr>
            	<td colspan="2">TEL: 031 0000000, FAX: 031 0000000</td>
            </tr>
            <tr>
            	<td colspan="2">Month of {{$paymonth_name}} <!--{{$more_info}}--></td>
            </tr>
        </table>
        
    </div>
    <div id="footer">
      <div class="page-number"></div>
    </div>
    @php $check=0 @endphp
    
        
        	<table width="100%" border="0" cellpadding="2" cellspacing="0" class="pdf_data">
                <thead>
                    <tr class="col_border">
                        <th style="text-align:center;">EPF <br />NO</th>
                        <th style="text-align:center;">Employee Name</th>
                        <th style="text-align:center;">Basic</th>
                        <th style="text-align:center;">BRA I</th>
                        <th style="text-align:center;">BRA II</th>
                        <th style="text-align:center;">No-pay</th>
                        <th style="text-align:center;">Total <br />Before <br />Nopay</th>
                        <th class="" style="text-align:center;">Arrears</th>
                        <!--th class="" style="text-align:center;">Total for <br />Tax</th-->
                        <th style="text-align:center;">Weekly <br />Attendance</th><!--th style="text-align:center;">Attendance</th-->
                        <th style="text-align:center;">Incentive</th>
                        <th style="text-align:center;">Director <br />Incentive</th>
                        <!--th style="text-align:center;">Transport</th-->
                        <!--th>Other Addition</th-->
                        <th style="text-align:center;">Salary <br />Arrears</th>
                        <th style="text-align:center;">Normal</th>
                        <th style="text-align:center;">Double</th>
                        <th style="text-align:center;">Total <br />Earned</th>
                        <th class="" style="text-align:center;">Total for <br />Tax</th>
                        <th style="text-align:center;">EPF-8</th>
                        <th style="text-align:center;">Salary <br />Advance</th>
                        <th style="text-align:center;">Loans</th>
                        <!--th style="text-align:center;">Telephone</th-->
                        <th style="text-align:center;">IOU <br />Deduction</th>
                        <th style="text-align:center;">Funeral <br />Fund</th>
                        <th style="text-align:center;">P.A.Y.E.</th>
                        <th style="text-align:center;">Other<!-- Deductions--></th>
                        <!--th style="text-align:center;">P.A.Y.E.</th-->
                        <!--th style="text-align:center;">Loans</th-->
                        <th style="text-align:center;">Total <br />Deductions</th>
                        <th style="text-align:center;">Balance <br />Pay</th>
                        <th style="text-align:center;">EPF-12</th>
                        <th style="text-align:center;">ETF-3</th>
                    </tr>
                </thead>
             	
                <tbody class="">
                @foreach ($emp_array as $row)
                    @if( $check > 0 )
                    <tr class="col_border">
                        <td>{{ $row['emp_epfno'] }}</td>
                        <td>{{ $row['emp_first_name'] }}</td>
                        <td>{{ number_format((float)$row['BASIC'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['BRA_I'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['add_bra2'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['NOPAY'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['tot_bnp'], 2, '.', ',') }}</td>
                        <td class="">{{ number_format((float)$row['sal_arrears1'], 2, '.', ',') }}</td>
                        
                        <td>{{ number_format((float)$row['ATTBONUS_W'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['INCNTV_EMP'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['INCNTV_DIR'], 2, '.', ',') }}</td>
                        
                        <!--td>number_format((float)$row['add_transport'], 2, '.', ',')</td-->
                        <!--td>{{ number_format((float)$row['add_other'], 2, '.', '') }}</td-->
                        <td>{{ number_format((float)$row['sal_arrears2'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['OTHRS1'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['OTHRS2'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['tot_earn'], 2, '.', ',') }}</td>
                        <td class="">{{ number_format((float)$row['tot_fortax'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['EPF8'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['sal_adv'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['LOAN'], 2, '.', ',') }}</td>
                        <!--td>number_format((float)$row['ded_tp'], 2, '.', ',')</td-->
                        <td>{{ number_format((float)$row['ded_IOU'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['ded_fund_1'], 2, '.', ',') }}</td>
                        
                        <td>{{ number_format((float)$row['PAYE'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['ded_other'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['tot_ded'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['NETSAL'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['EPF12'], 2, '.', ',') }}</td>
                        <td>{{ number_format((float)$row['ETF3'], 2, '.', ',') }}</td>
                  </tr>
                  @endif
                  @php $check++ @endphp
                @endforeach
                </tbody>
                
                <tfoot>
                	<tr class="foot_row">
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="10">&nbsp;</td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Prepared By</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Checked By</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Checked By</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Approved By</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Print Date</td>
                        <td colspan="7">&nbsp;</td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr class="sign_row">
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2" class="sign_col">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2" class="sign_col">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2" class="sign_col">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2" class="sign_col">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2" class="sign_col" style="vertical-align:bottom;">{{\Carbon\Carbon::now()->format('Y-m-d')}}</td>
                        <td colspan="7">&nbsp;</td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">System Administrator</td>
                        <td>&nbsp;</td>
                        <td colspan="2">HR Executive</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Accountant</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Managing Director</td>
                        <td colspan="10">&nbsp;</td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <!--tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">Managing Director</td>
                        <td colspan="10">&nbsp;</td>
                    </tr-->
                </tfoot>
            </table>
            
            
            
            
        	
        
      
  </body>
</html>