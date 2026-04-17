export interface Statement {
  period_from: string;
  period_to: string;
  opening_in_balance_amount: number;
  opening_out_balance_amount: number;
  closing_in_balance_amount: number;
  closing_out_balance_amount: number;
}

export interface StatementError {
  period_from?: string;
  period_to?: string;
}
