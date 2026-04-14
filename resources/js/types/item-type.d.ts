import type { Category } from '@/types/category';

export interface ItemType {
  id: string;
  category: Category;
  code: string;
  name: string;
  description: string;
  deleted_at: string | null;
}

export interface ItemTypeError {
  category?: string;
  code?: string;
  name?: string;
  description?: string;
}
