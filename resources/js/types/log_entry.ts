// Níveis e tipos de log
export type LogLevel = 'info' | 'debug' | 'error' | 'notice' | 'warning';
export type LogType = 'raw' | 'insert' | 'update' | 'delete' | 'read';

// Recurso referenciado
export interface Resource {
    table: string;
    id: string;
}

// Estruturas possíveis para "data"
export interface LogDataRaw {
    message: string;
}

export interface LogDataInsert {
    after: Record<string, unknown>;
}

export interface LogDataUpdate {
    before: Record<string, unknown>;
    after: Record<string, unknown>;
}

export interface LogDataDelete {
    before: Record<string, unknown>;
}

export interface LogDataRead {
    profiles: string[];
    reason: string;
}

export type LogData<T extends LogType> = T extends 'raw'
    ? LogDataRaw
    : T extends 'insert'
      ? LogDataInsert
      : T extends 'update'
        ? LogDataUpdate
        : T extends 'delete'
          ? LogDataDelete
          : T extends 'read'
            ? LogDataRead
            : never;

// Tipo principal do log
export interface LogEntry<T extends LogType = LogType> {
    _id?: string;
    system: string;
    description: string;
    level: LogLevel;
    type: T;
    user: string;
    ip: string | null;
    resources: Resource[];
    timestamp: number;
    data: LogData<T>;
    file: string | null;
}

// Tipo geral para lista de logs
export type AnyLogEntry = LogEntry;
