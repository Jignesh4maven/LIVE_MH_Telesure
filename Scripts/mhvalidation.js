function validateRSAidnumber(identity_number) {

  // the anatomy of an RSA ID Number : http://warwickchapman.com/the-anatomy-of-an-rsa-id-number
  // structure: (YYMMDD GSSS CAZ)

  var idnumber = identity_number ,
    invalid = 0;

  // check that value submitted is a number
  if (isNaN(idnumber)) {
    console.log('Value supplied is not a valid number.<br />');
    invalid++;
  }

  // check length of 13 digits
  if (idnumber.length != 13) {
    console.log('Number supplied does not have 13 digits.<br />');
    invalid++;
  }

  // check that YYMMDD group is a valid date
  var yy = idnumber.substring(0, 2),
    mm = idnumber.substring(2, 4),
    dd = idnumber.substring(4, 6);

  var dob = new Date(yy, (mm - 1), dd);

  // check values - add one to month because Date() uses 0-11 for months
  if (!(((dob.getFullYear() + '').substring(2, 4) == yy) && (dob.getMonth() == mm - 1) && (dob.getDate() == dd))) {
    console.log('Date in first 6 digits is invalid.<br />');
    invalid++;
  }

  // evaluate GSSS group for gender and sequence 
  var gender = parseInt(idnumber.substring(6, 10), 10) > 5000 ? "M" : "F";

  // ensure third to last digit is a 1 or a 0
  if (idnumber.substring(10, 11) > 1) {
    console.log('Third to last digit can only be a 0 or 1 but is a ' + idnumber.substring(10, 11) + '.<br />');
    invalid++;
  } else {
    // determine citizenship from third to last digit (C)
    var saffer = parseInt(idnumber.substring(10, 11), 10) === 0 ? "C" : "F";
  }

  // ensure second to last digit is a 8 or a 9
  if (idnumber.substring(11, 12) < 8) {
    console.log('Second to last digit can only be a 8 or 9 but is a ' + idnumber.substring(11, 12) + '.<br />');
    invalid++;
  }

  // calculate check bit (Z) using the Luhn algorithm
  var ncheck = 0,
    beven = false;

  for (var c = idnumber.length - 1; c >= 0; c--) {
    var cdigit = idnumber.charAt(c),
      ndigit = parseInt(cdigit, 10);

    if (beven) {
      if ((ndigit *= 2) > 9) ndigit -= 9;
    }

    ncheck += ndigit;
    beven = !beven;
  }

  if ((ncheck % 10) !== 0) {
    console.log('Checkbit is incorrect.<br />');
    invalid++;
  }

  // if one or more checks fail, display details
  if (invalid > 0) {
    //debug.css('display', 'block');
  }
  console.log("validateRSAidnumber:"+ncheck % 10);
  return invalid;
  
  //return (ncheck % 10) === 0;
}