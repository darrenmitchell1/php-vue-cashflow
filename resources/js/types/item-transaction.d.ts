import type { Item } from '@/types/item';

export interface ItemTransaction {
  id: string;
  item: Item | null;
  transaction_date: string;
  amount: float;
}
