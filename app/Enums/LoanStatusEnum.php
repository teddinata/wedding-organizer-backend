<?php

namespace App\Enums;

enum LoanStatusEnum: string
{
  case WAITINGAPPROVAL = 'Waiting Approval';
  case ONGOING = 'Ongoing';
  case PAID = 'Paid';
  case REJECTED = 'Rejected';
}
