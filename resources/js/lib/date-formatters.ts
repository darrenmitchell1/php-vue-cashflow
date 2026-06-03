function toEndDate(startDate: Date, frequency: string, numberOfTransactions: number) : Date {
  const endDate = new Date(startDate);

  switch (frequency) {
    case 'single':
      endDate.setDate(endDate.getDate());
      break;
    case 'daily':
      endDate.setDate(endDate.getDate() + (numberOfTransactions - 1));
      break;
    case 'weekly':
      endDate.setDate(endDate.getDate() + ((numberOfTransactions - 1) * 7));
      break;
    case 'monthly':
      endDate.setMonth(endDate.getMonth() + (numberOfTransactions - 1));

      const expectedMonth = (endDate.getMonth() + (numberOfTransactions - 1)) % 12;

      // If the month overflowed past the target month, force it to the last day of the target month
      if (endDate.getMonth() !== expectedMonth && endDate.getMonth() !== (expectedMonth + 12) % 12) {
        endDate.setDate(0); // Sets the date to the last day of the prior month
      }
      break;
    default:
      throw new Error(`Unsupported frequency: ${frequency}`);
  }

  return endDate;
}

export { toEndDate }
