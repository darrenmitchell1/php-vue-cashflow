import type { ItemType } from '@/types/item-type';
import type { Flow } from '@/types/flow';
import type { Frequency } from '@/types/frequency';

export interface Item {
  id: string;
  item_type: ItemType | null;
  flow: Flow;
  frequency: Frequency;
  start_date: string;
  number_of_transactions: string;
  description: string;
  company_name: string;
  amount: float;
  reference: string | null;
}

export interface ItemError {
  item_type_id?: string;
  flow?: string;
  frequency?: string;
  start_date?: string;
  number_of_transactions?: string;
  description?: string;
  company_name?: string;
  amount?: string;
  reference?: string;
}
