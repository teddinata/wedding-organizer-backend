<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
  case NEW = 'New';
  case ONGOING = 'Ongoing';
  case CHECKLISTDONE = 'Checklist Done';
  case ONTHEWAY = 'On the way';
  case ARRIVED = 'Arrived';
  case WORKSTART = 'Work Started';
  case WORKEND = 'Work Done';
  case HANDOVER = 'Handover';
  case COMPLETED = 'Completed';
}
