import type { Category } from '@/types/category';

export interface ItemType {
  id: string;
  category: Category;
  code: string;
  name: string;
  description: string;
}
